import React from 'react';
import { useNavigate } from 'react-router-dom';

const PedidoConfirmado: React.FC = () => {
  const navigate = useNavigate();

  return (
    <div className="min-h-screen bg-gradient-warm flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
      <div className="max-w-md w-full space-y-8 text-center">
        <div>
          {/* Ícono de éxito */}
          <div className="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100 mb-6">
            <svg className="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
            </svg>
          </div>
          
          <h2 className="text-3xl font-logo font-bold text-coffee-800 mb-4">
            ¡Pedido Confirmado!
          </h2>
          
          <div className="bg-white p-6 rounded-2xl shadow-lg border border-crepe-200 mb-6">
            <h3 className="text-lg font-semibold text-coffee-700 mb-3">💵 Pago Contra Entrega</h3>
            <div className="text-coffee-600 space-y-2">
              <p>✅ Tu pedido ha sido confirmado</p>
              <p>📞 Te contactaremos pronto para coordinar la entrega</p>
              <p>💰 Pagarás en efectivo cuando recibas tu pedido</p>
            </div>
          </div>
          
          <div className="bg-crepe-50 p-4 rounded-xl border border-crepe-200 mb-6">
            <h4 className="font-semibold text-coffee-700 mb-2">📋 Próximos pasos:</h4>
            <ul className="text-sm text-coffee-600 text-left space-y-1">
              <li>• Mantén tu teléfono disponible</li>
              <li>• Prepara el dinero exacto (si es posible)</li>
              <li>• Confirma tu dirección de entrega</li>
            </ul>
          </div>

          <div className="space-y-3">
            <button
              onClick={() => navigate('/')}
              className="w-full bg-accent-red text-white py-3 px-6 rounded-xl font-semibold hover:bg-red-600 transition-colors"
            >
              🏠 Volver al Inicio
            </button>
            
            <button
              onClick={() => navigate('/productos')}
              className="w-full bg-coffee-600 text-white py-3 px-6 rounded-xl font-semibold hover:bg-coffee-700 transition-colors"
            >
              🛍️ Seguir Comprando
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default PedidoConfirmado; 