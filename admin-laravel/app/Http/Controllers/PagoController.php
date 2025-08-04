<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;

class PagoController extends Controller
{
    public function __construct()
    {
        SDK::setAccessToken(config('services.mercadopago.access_token'));
    }

    public function crearPreferencia(Request $request): JsonResponse
    {
        $request->validate([
            'pedido_id' => 'required|exists:pedidos,id',
        ]);

        $pedido = Pedido::with('detallePedidos.producto')->findOrFail($request->pedido_id);
        
        // Verificar que el pedido use Mercado Pago
        if ($pedido->metodo_pago !== 'mercado_pago') {
            return response()->json([
                'error' => 'Este pedido no está configurado para pago con Mercado Pago'
            ], 400);
        }

        $preference = new Preference();

        $items = [];
        foreach ($pedido->detallePedidos as $detalle) {
            $item = new Item();
            $item->title = $detalle->producto->nombre;
            $item->quantity = $detalle->cantidad;
            $item->unit_price = $detalle->precio_unitario;
            $items[] = $item;
        }

        $preference->items = $items;
        $preference->back_urls = [
            'success' => env('FRONTEND_URL', 'http://localhost:3000') . '/pago/exito',
            'failure' => env('FRONTEND_URL', 'http://localhost:3000') . '/pago/fallo',
            'pending' => env('FRONTEND_URL', 'http://localhost:3000') . '/pago/pendiente',
        ];
        $preference->auto_return = 'approved';
        $preference->external_reference = $pedido->id;

        $preference->save();

        $pedido->update([
            'mercadopago_preference_id' => $preference->id
        ]);

        return response()->json([
            'init_point' => $preference->init_point,
            'preference_id' => $preference->id
        ]);
    }

    public function webhook(Request $request): JsonResponse
    {
        $type = $request->input('type');
        $data = $request->input('data');

        if ($type === 'payment') {
            $payment = \MercadoPago\Payment::find_by_id($data['id']);
            
            if ($payment) {
                $pedido = Pedido::where('mercadopago_preference_id', $payment->preference_id)->first();
                
                if ($pedido) {
                    $pedido->update([
                        'mercadopago_payment_id' => $payment->id,
                        'estado' => $payment->status === 'approved' ? 'confirmado' : 'pendiente'
                    ]);
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
