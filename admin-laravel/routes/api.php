<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\AdminController;

// Ruta de prueba para verificar CORS
Route::get('/test', function () {
    return response()->json([
        'message' => 'CORS test successful',
        'timestamp' => now(),
        'status' => 'working'
    ]);
});

// Ruta de prueba para login sin DB
Route::post('/test-login', function (Request $request) {
    return response()->json([
        'message' => 'Login test successful',
        'email' => $request->input('email'),
        'status' => 'working',
        'token' => 'test-token-12345'
    ]);
});

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Rutas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas de productos y categorías (públicas)
Route::get('/productos', [ProductoController::class, 'index']);
Route::get('/categorias', [CategoriaController::class, 'index']);

// Webhook de Mercado Pago
Route::post('/webhook/mercadopago', [PagoController::class, 'webhook']);

// Rutas protegidas (requieren autenticación)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // Carrito
    Route::get('/carrito', [PedidoController::class, 'getCarrito']);
    Route::post('/carrito/agregar', [PedidoController::class, 'agregarAlCarrito']);
    Route::put('/carrito/actualizar', [PedidoController::class, 'actualizarCarrito']);
    Route::delete('/carrito/eliminar/{productoId}', [PedidoController::class, 'eliminarDelCarrito']);
    Route::delete('/carrito/vaciar', [PedidoController::class, 'vaciarCarrito']);
    
    // Pedidos
    Route::post('/pedidos', [PedidoController::class, 'store']);
    Route::get('/pedidos', [PedidoController::class, 'misPedidos']);
    Route::get('/pedidos/{id}', [PedidoController::class, 'show']);
    
    // Pagos
    Route::post('/pagos/preferencia', [PagoController::class, 'crearPreferencia']);
});

// Ruta de login para admin (sin middleware para permitir el login inicial)
Route::post('/admin/login', [AdminController::class, 'login']);

// Rutas de administración (requieren autenticación y rol admin)
Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    // Dashboard y perfil
    Route::get('/me', [AdminController::class, 'me']);
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    
    // Gestión de Productos
    Route::get('/products', [AdminController::class, 'products']);
    Route::get('/products/{id}', [AdminController::class, 'showProduct']);
    Route::post('/products', [AdminController::class, 'storeProduct']);
    Route::put('/products/{id}', [AdminController::class, 'updateProduct']);
    Route::delete('/products/{id}', [AdminController::class, 'deleteProduct']);
    
    // Subida de imágenes
    Route::post('/upload-image', [AdminController::class, 'uploadImage']);
    
    // Gestión de Categorías
    Route::get('/categories', [AdminController::class, 'categories']);
    Route::get('/categories/{id}', [AdminController::class, 'showCategory']);
    Route::post('/categories', [AdminController::class, 'storeCategory']);
    Route::put('/categories/{id}', [AdminController::class, 'updateCategory']);
    Route::delete('/categories/{id}', [AdminController::class, 'deleteCategory']);
    
    // Gestión de Pedidos
    Route::get('/orders', [AdminController::class, 'orders']);
    Route::get('/orders/{id}', [AdminController::class, 'showOrder']);
    Route::put('/orders/{id}/status', [AdminController::class, 'updateOrderStatus']);
    
    // Gestión de Usuarios
    Route::get('/users', [AdminController::class, 'users']);
    Route::get('/users/{id}', [AdminController::class, 'showUser']);
    Route::put('/users/{id}', [AdminController::class, 'updateUser']);
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
    
    // Estadísticas
    Route::get('/stats', [AdminController::class, 'stats']);
    Route::get('/stats/sales', [AdminController::class, 'salesStats']);
    Route::get('/stats/orders', [AdminController::class, 'orderStats']);
}); 