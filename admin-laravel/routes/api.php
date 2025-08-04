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

// Ruta de prueba para registro sin tokens
Route::post('/test-register', function (Request $request) {
    try {
        $user = \App\Models\User::create([
            'name' => $request->input('name', 'Test User'),
            'email' => $request->input('email', 'test@example.com'),
            'password' => \Hash::make($request->input('password', '12345678')),
            'telefono' => $request->input('telefono', '123456789'),
            'direccion' => $request->input('direccion', 'Test Address'),
            'rol' => 'cliente',
        ]);
        
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
            'status' => 'success'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error creating user',
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
            'status' => 'error'
        ], 500);
    }
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

// Ruta de prueba para ADMIN login sin DB
Route::post('/admin/test-login', function (Request $request) {
    return response()->json([
        'message' => 'Admin login test successful - CORS working!',
        'email' => $request->input('email'),
        'status' => 'working',
        'token' => 'test-admin-token-12345',
        'user' => [
            'id' => 1,
            'name' => 'Test Admin',
            'email' => $request->input('email'),
            'role' => 'admin'
        ]
    ]);
});

// Ruta para crear usuario admin en PostgreSQL
Route::get('/create-admin', function (Request $request) {
    try {
        $existingAdmin = \App\Models\User::where('email', 'admin@crepesandcoffee.com')->first();
        
        if ($existingAdmin) {
            return response()->json([
                'message' => 'Admin user already exists',
                'email' => $existingAdmin->email,
                'status' => 'exists'
            ]);
        }
        
        $admin = \App\Models\User::create([
            'name' => 'Administrador',
            'email' => 'admin@crepesandcoffee.com',
            'password' => \Hash::make('admin123'),
            'rol' => 'admin',
            'email_verified_at' => now(),
        ]);
        
        return response()->json([
            'message' => 'Admin user created successfully',
            'email' => $admin->email,
            'status' => 'created'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error creating admin user',
            'error' => $e->getMessage(),
            'status' => 'error'
        ], 500);
    }
});

// Ruta para probar conexión PostgreSQL directa
Route::get('/test-db', function () {
    try {
        $connection = \DB::connection('pgsql');
        $pdo = $connection->getPdo();
        
        return response()->json([
            'message' => 'Database connection successful',
            'driver' => $pdo->getAttribute(PDO::ATTR_DRIVER_NAME),
            'server_info' => $pdo->getAttribute(PDO::ATTR_SERVER_INFO),
            'status' => 'connected'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Database connection failed',
            'error' => $e->getMessage(),
            'status' => 'error'
        ], 500);
    }
});

// Ruta para probar configuración de entorno
Route::get('/test-env', function () {
    return response()->json([
        'DB_CONNECTION' => env('DB_CONNECTION'),
        'DB_HOST' => env('DB_HOST'),
        'DB_PORT' => env('DB_PORT'),
        'DB_DATABASE' => env('DB_DATABASE'),
        'DB_USERNAME' => env('DB_USERNAME'),
        'DB_PASSWORD' => env('DB_PASSWORD') ? '[SET]' : '[NOT SET]',
        'DB_URL' => env('DB_URL') ? '[SET]' : '[NOT SET]',
        'DB_SSLMODE' => env('DB_SSLMODE'),
        'PGSSLMODE' => env('PGSSLMODE'),
        'status' => 'config_displayed'
    ]);
});

// Ruta para probar conexión PostgreSQL RAW (sin Laravel DB)
Route::get('/test-raw-db', function () {
    try {
        $dbUrl = env('DB_URL');
        
        if (!$dbUrl) {
            return response()->json([
                'message' => 'DB_URL not found',
                'status' => 'error'
            ], 500);
        }
        
        // Parse DB_URL manualmente
        $url = parse_url($dbUrl);
        
        $dsn = sprintf(
            'pgsql:host=%s;port=%d;dbname=%s;sslmode=require',
            $url['host'],
            $url['port'] ?? 5432,
            ltrim($url['path'], '/')
        );
        
        $pdo = new PDO($dsn, $url['user'], $url['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 120,
            PDO::ATTR_PERSISTENT => false,
        ]);
        
        // Probar query simple
        $result = $pdo->query("SELECT version()")->fetchColumn();
        
        return response()->json([
            'message' => 'Raw PostgreSQL connection successful',
            'version' => $result,
            'dsn' => str_replace($url['pass'], '[HIDDEN]', $dsn),
            'status' => 'connected'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Raw PostgreSQL connection failed',
            'error' => $e->getMessage(),
            'status' => 'error'
        ], 500);
    }
});

// Ruta para probar conexión con DB_URL directo (como DSN)
Route::get('/test-dsn', function () {
    try {
        $dbUrl = env('DB_URL');
        
        if (!$dbUrl) {
            return response()->json([
                'message' => 'DB_URL not found',
                'status' => 'error'
            ], 500);
        }
        
        // Usar DB_URL directamente como DSN para PDO
        $pdo = new PDO($dbUrl, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 120,
            PDO::ATTR_PERSISTENT => false,
        ]);
        
        // Probar query simple
        $result = $pdo->query("SELECT version()")->fetchColumn();
        
        return response()->json([
            'message' => 'Direct DSN connection successful',
            'version' => $result,
            'status' => 'connected'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Direct DSN connection failed',
            'error' => $e->getMessage(),
            'status' => 'error'
        ], 500);
    }
});

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Rutas públicas - versión simplificada para debug
Route::post('/register', function (Request $request) {
    try {   
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'rol' => 'cliente',
        ]);

        return response()->json([
            'user' => $user,
            'message' => 'Usuario registrado exitosamente'
        ], 201);
        
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error en registro',
            'error' => $e->getMessage()
        ], 500);
    }
});

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