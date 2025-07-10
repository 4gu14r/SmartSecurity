<?php

// Autoload do Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Carregar variáveis de ambiente
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
}

// Configurações de erro
if ($_ENV['APP_DEBUG'] ?? false) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Configurações de sessão
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
ini_set('session.use_strict_mode', 1);

use SmartSecurity\Utils\Router;
use SmartSecurity\Controllers\HomeController;
use SmartSecurity\Controllers\AuthController;
use SmartSecurity\Controllers\OccurrenceController;
use SmartSecurity\Controllers\AdminController;

// Criar instância do router
$router = new Router();

// Middleware para CORS (se necessário)
$router->middleware(function() {
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        }
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        }
        
        exit(0);
    }
});

// Rotas públicas
$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [HomeController::class, 'about']);
$router->get('/contact', [HomeController::class, 'contact']);
$router->post('/contact', [HomeController::class, 'sendContact']);
$router->get('/privacy', [HomeController::class, 'privacy']);
$router->get('/terms', [HomeController::class, 'terms']);
$router->get('/statistics', [HomeController::class, 'statistics']);
$router->get('/search', [HomeController::class, 'search']);

// Rotas de autenticação
$router->get('/login', [AuthController::class, 'showLogin']);
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout']);

// Rotas protegidas
$router->get('/dashboard', [HomeController::class, 'dashboard']);
$router->get('/profile', [AuthController::class, 'showProfile']);
$router->post('/profile', [AuthController::class, 'updateProfile']);

// Rotas de ocorrências
$router->get('/occurrences', [OccurrenceController::class, 'index']);
$router->get('/occurrences/create', [OccurrenceController::class, 'create']);
$router->post('/occurrences', [OccurrenceController::class, 'store']);
$router->get('/occurrences/{id}', [OccurrenceController::class, 'show']);
$router->get('/occurrences/{id}/edit', [OccurrenceController::class, 'edit']);
$router->post('/occurrences/{id}', [OccurrenceController::class, 'update']);
$router->delete('/occurrences/{id}', [OccurrenceController::class, 'delete']);

// Rotas de administração
$router->get('/admin', [AdminController::class, 'index']);
$router->get('/admin/users', [AdminController::class, 'users']);
$router->get('/admin/users/{id}', [AdminController::class, 'showUser']);
$router->post('/admin/users/{id}', [AdminController::class, 'updateUser']);
$router->delete('/admin/users/{id}', [AdminController::class, 'deleteUser']);

// API Routes
$router->get('/api/statistics', function() {
    header('Content-Type: application/json');
    $occurrenceModel = new \SmartSecurity\Models\Occurrence();
    echo json_encode([
        'occurrence_stats' => $occurrenceModel->getOccurrenceStats(),
        'location_stats' => $occurrenceModel->getLocationStats(),
        'monthly_stats' => $occurrenceModel->getMonthlyStats()
    ]);
});

// Tratamento de erros global
set_exception_handler(function($exception) {
    if ($_ENV['APP_DEBUG'] ?? false) {
        echo "<h1>Erro:</h1>";
        echo "<p>" . $exception->getMessage() . "</p>";
        echo "<pre>" . $exception->getTraceAsString() . "</pre>";
    } else {
        http_response_code(500);
        include __DIR__ . '/../src/Views/errors/500.php';
    }
});

// Executar o router
try {
    $router->dispatch();
} catch (Exception $e) {
    if ($_ENV['APP_DEBUG'] ?? false) {
        throw $e;
    } else {
        http_response_code(500);
        include __DIR__ . '/../src/Views/errors/500.php';
    }
}

