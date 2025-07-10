<?php

namespace SmartSecurity\Controllers;

use SmartSecurity\Utils\Session;

abstract class BaseController
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);
        
        $viewPath = __DIR__ . "/../Views/{$view}.php";
        
        if (!file_exists($viewPath)) {
            throw new \Exception("View {$view} não encontrada.");
        }
        
        include $viewPath;
    }
    
    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }
    
    protected function requireAuth(): void
    {
        if (!Session::isLoggedIn()) {
            Session::flash('error', 'Você precisa estar logado para acessar esta página.');
            $this->redirect('/login');
        }
    }
    
    protected function requireAdmin(): void
    {
        $this->requireAuth();
        
        if (Session::getUserRole() !== 'Administrador') {
            Session::flash('error', 'Acesso negado. Apenas administradores podem acessar esta página.');
            $this->redirect('/dashboard');
        }
    }
    
    protected function getInput(): array
    {
        $input = [];
        
        // GET parameters
        $input = array_merge($input, $_GET);
        
        // POST parameters
        $input = array_merge($input, $_POST);
        
        // JSON input
        $jsonInput = json_decode(file_get_contents('php://input'), true);
        if ($jsonInput) {
            $input = array_merge($input, $jsonInput);
        }
        
        return $input;
    }
    
    protected function sanitizeInput(array $input): array
    {
        return array_map(function($value) {
            if (is_string($value)) {
                return trim(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
            }
            return $value;
        }, $input);
    }
    
    protected function validateCsrf(): bool
    {
        $token = $_POST['csrf_token'] ?? $_GET['csrf_token'] ?? '';
        $sessionToken = Session::get('csrf_token');
        
        return hash_equals($sessionToken, $token);
    }
    
    protected function generateCsrfToken(): string
    {
        $token = bin2hex(random_bytes(32));
        Session::set('csrf_token', $token);
        return $token;
    }
    
    protected function handleFileUpload(string $fieldName, array $allowedTypes = [], int $maxSize = 5242880): ?array
    {
        if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
            return null;
        }
        
        $file = $_FILES[$fieldName];
        
        // Verificar tamanho
        if ($file['size'] > $maxSize) {
            throw new \Exception('Arquivo muito grande. Tamanho máximo: ' . ($maxSize / 1024 / 1024) . 'MB');
        }
        
        // Verificar tipo
        $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!empty($allowedTypes) && !in_array($fileType, $allowedTypes)) {
            throw new \Exception('Tipo de arquivo não permitido. Tipos aceitos: ' . implode(', ', $allowedTypes));
        }
        
        // Gerar nome único
        $fileName = uniqid() . '.' . $fileType;
        $uploadPath = __DIR__ . '/../../public/uploads/' . $fileName;
        
        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new \Exception('Erro ao fazer upload do arquivo.');
        }
        
        return [
            'original_name' => $file['name'],
            'file_name' => $fileName,
            'file_path' => '/uploads/' . $fileName,
            'file_size' => $file['size'],
            'file_type' => $fileType
        ];
    }
}

