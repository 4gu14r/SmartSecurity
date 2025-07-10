<?php

namespace SmartSecurity\Controllers;

use SmartSecurity\Models\Occurrence;
use SmartSecurity\Models\User;
use SmartSecurity\Utils\Session;

class HomeController extends BaseController
{
    private Occurrence $occurrenceModel;
    private User $userModel;
    
    public function __construct()
    {
        $this->occurrenceModel = new Occurrence();
        $this->userModel = new User();
    }
    
    public function index(): void
    {
        // Estatísticas públicas para visitantes
        $stats = $this->occurrenceModel->getOccurrenceStats();
        $locationStats = $this->occurrenceModel->getLocationStats();
        $recentOccurrences = $this->occurrenceModel->getRecentOccurrences(3);
        
        $this->view('home/index', [
            'stats' => $stats,
            'locationStats' => $locationStats,
            'recentOccurrences' => $recentOccurrences,
            'isLoggedIn' => Session::isLoggedIn(),
            'userName' => Session::get('user_data')['nome'] ?? null
        ]);
    }
    
    public function dashboard(): void
    {
        $this->requireAuth();
        
        $userId = Session::getUserId();
        $userRole = Session::getUserRole();
        
        // Estatísticas gerais
        $occurrenceStats = $this->occurrenceModel->getOccurrenceStats();
        $locationStats = $this->occurrenceModel->getLocationStats();
        $monthlyStats = $this->occurrenceModel->getMonthlyStats();
        
        // Ocorrências do usuário
        $userOccurrences = $this->occurrenceModel->getOccurrencesByUser($userId);
        $recentOccurrences = $this->occurrenceModel->getRecentOccurrences(5);
        
        $data = [
            'user' => Session::get('user_data'),
            'userRole' => $userRole,
            'occurrenceStats' => $occurrenceStats,
            'locationStats' => $locationStats,
            'monthlyStats' => $monthlyStats,
            'userOccurrences' => $userOccurrences,
            'recentOccurrences' => $recentOccurrences,
            'userOccurrenceCount' => count($userOccurrences)
        ];
        
        // Estatísticas adicionais para administradores
        if ($userRole === 'Administrador') {
            $data['userStats'] = $this->userModel->getUserStats();
            $data['allUsers'] = $this->userModel->getAllUsersWithProfile();
        }
        
        $this->view('dashboard/index', $data);
    }
    
    public function about(): void
    {
        $this->view('home/about');
    }
    
    public function contact(): void
    {
        $this->view('home/contact', [
            'csrf_token' => $this->generateCsrfToken(),
            'success' => Session::getFlash('success'),
            'error' => Session::getFlash('error')
        ]);
    }
    
    public function sendContact(): void
    {
        $input = $this->sanitizeInput($this->getInput());
        
        if (!$this->validateCsrf()) {
            Session::flash('error', 'Token de segurança inválido.');
            $this->redirect('/contact');
        }
        
        // Aqui você pode implementar o envio de email
        // Por enquanto, apenas simular o envio
        
        Session::flash('success', 'Mensagem enviada com sucesso! Entraremos em contato em breve.');
        $this->redirect('/contact');
    }
    
    public function privacy(): void
    {
        $this->view('home/privacy');
    }
    
    public function terms(): void
    {
        $this->view('home/terms');
    }
    
    public function statistics(): void
    {
        // Página pública de estatísticas
        $occurrenceStats = $this->occurrenceModel->getOccurrenceStats();
        $locationStats = $this->occurrenceModel->getLocationStats();
        $monthlyStats = $this->occurrenceModel->getMonthlyStats();
        
        $this->view('home/statistics', [
            'occurrenceStats' => $occurrenceStats,
            'locationStats' => $locationStats,
            'monthlyStats' => $monthlyStats
        ]);
    }
    
    public function search(): void
    {
        $input = $this->sanitizeInput($this->getInput());
        $search = $input['q'] ?? '';
        $type = $input['type'] ?? 'all';
        $location = $input['location'] ?? '';
        
        $results = [];
        
        if (!empty($search)) {
            $results = $this->occurrenceModel->searchOccurrences($search);
        } elseif (!empty($location)) {
            $results = $this->occurrenceModel->getOccurrencesByLocation($location);
        } elseif ($type !== 'all') {
            $results = $this->occurrenceModel->getOccurrencesByType($type);
        } else {
            $results = $this->occurrenceModel->getOccurrencesWithUser();
        }
        
        // Se for uma requisição AJAX, retornar JSON
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            $this->json([
                'success' => true,
                'results' => $results,
                'total' => count($results)
            ]);
        }
        
        $this->view('home/search', [
            'results' => $results,
            'search' => $search,
            'type' => $type,
            'location' => $location,
            'total' => count($results)
        ]);
    }
}

