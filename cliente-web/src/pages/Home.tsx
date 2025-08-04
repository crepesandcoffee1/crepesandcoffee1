import React from 'react';
import { Link } from 'react-router-dom';

const Home: React.FC = () => {
  return (
    <div className="min-h-screen bg-gradient-warm">
      {/* Hero Section */}
      <section className="relative py-20 px-4 sm:px-6 lg:px-8">
        <div className="max-w-7xl mx-auto">
          <div className="text-center">
            {/* Logo */}
            <div className="mb-8">
              <img 
                src="/logo.jpg"
                alt="Crepes & Coffee Logo" 
                className="h-32 md:h-40 w-auto mx-auto mb-8 rounded-2xl shadow-2xl"
              />
            </div>
            
            {/* Título Principal */}
            <h1 className="text-5xl md:text-6xl font-logo font-bold text-coffee-800 mb-6">
              Crepes <span className="text-accent-red">&</span> Coffee
            </h1>
            
            {/* Subtítulo */}
            <p className="text-xl md:text-2xl text-coffee-600 font-serif mb-8 max-w-3xl mx-auto leading-relaxed">
              Descubre el arte de los crepes artesanales y el café de especialidad en un ambiente cálido y acogedor
            </p>
            
            {/* Call to Action */}
            <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
              <Link
                to="/productos"
                className="bg-gradient-to-r from-coffee-600 to-coffee-700 text-white px-8 py-4 rounded-xl font-logo font-semibold text-lg hover:from-coffee-700 hover:to-coffee-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1"
              >
                Ver Nuestro Menú
              </Link>
              <Link
                to="/register"
                className="bg-gradient-to-r from-accent-red to-red-600 text-white px-8 py-4 rounded-xl font-logo font-semibold text-lg hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1"
              >
                Crear Cuenta
              </Link>
            </div>
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section className="py-16 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-transparent to-crepe-50">
        <div className="max-w-7xl mx-auto">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-logo font-bold text-coffee-800 mb-4">
              ¿Por qué elegirnos?
            </h2>
            <p className="text-lg text-coffee-600 font-serif max-w-2xl mx-auto">
              Nos especializamos en crear experiencias gastronómicas únicas con ingredientes frescos y técnicas artesanales
            </p>
          </div>

          <div className="grid md:grid-cols-3 gap-8">
            {/* Feature 1 */}
            <div className="text-center p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-crepe-100">
              <div className="w-16 h-16 bg-gradient-to-r from-crepe-100 to-coffee-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg className="w-8 h-8 text-coffee-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <h3 className="text-xl font-logo font-semibold text-coffee-800 mb-2">Fresco y Rápido</h3>
              <p className="text-coffee-600 font-serif">
                Todos nuestros crepes se preparan al momento con ingredientes frescos y de la más alta calidad
              </p>
            </div>

            {/* Feature 2 */}
            <div className="text-center p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-crepe-100">
              <div className="w-16 h-16 bg-gradient-to-r from-crepe-100 to-coffee-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg className="w-8 h-8 text-coffee-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
              </div>
              <h3 className="text-xl font-logo font-semibold text-coffee-800 mb-2">Hecho con Amor</h3>
              <p className="text-coffee-600 font-serif">
                Cada crepe se prepara con dedicación y pasión, siguiendo recetas tradicionales y técnicas artesanales
              </p>
            </div>

            {/* Feature 3 */}
            <div className="text-center p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-crepe-100">
              <div className="w-16 h-16 bg-gradient-to-r from-crepe-100 to-coffee-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg className="w-8 h-8 text-coffee-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
              </div>
              <h3 className="text-xl font-logo font-semibold text-coffee-800 mb-2">Envío Gratis</h3>
              <p className="text-coffee-600 font-serif">
                Todos nuestros pedidos incluyen envío gratuito para que disfrutes de nuestros crepes en la comodidad de tu hogar
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-16 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-coffee-50 to-crepe-50">
        <div className="max-w-4xl mx-auto text-center">
          <h2 className="text-3xl md:text-4xl font-logo font-bold text-coffee-800 mb-6">
            ¿Listo para probar nuestros deliciosos crepes?
          </h2>
          <p className="text-lg text-coffee-600 font-serif mb-8">
            Explora nuestro menú y descubre una amplia variedad de sabores únicos y combinaciones exquisitas
          </p>
          <Link
            to="/productos"
            className="inline-block bg-gradient-to-r from-accent-red to-red-600 text-white px-10 py-4 rounded-xl font-logo font-semibold text-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1"
          >
            Ordenar Ahora
          </Link>
        </div>
      </section>
    </div>
  );
};

export default Home; 