<?php

namespace SmartSecurity\Controllers;

use SmartSecurity\Models\User;
use SmartSecurity\Utils\Session;
use SmartSecurity\Utils\Validator;

class AuthController extends BaseController
{
    private User $userModel;
    
    public function __construct()
    {
        $this->userModel = new User();
    }
    
    public function showLogin(): void
    {
        if (Session::isLoggedIn()) {
            $this->redirect('/dashboard');
        }
        
        $this->view('auth/login', [
            'csrf_token' => $this->generateCsrfToken(),
            'error' => Session::getFlash('error'),
            'success' => Session::getFlash('success')
        ]);
    }
    
    public function login(): void
    {
        $input = $this->sanitizeInput($this->getInput());
        
        if (!$this->validateCsrf()) {
            Session::flash('error', 'Token de segurança inválido.');
            $this->redirect('/login');
        }
        
        $validator = new Validator($input);
        $validator->required('email', 'Email é obrigatório')
                 ->email('email', 'Email deve ser válido')
                 ->required('senha', 'Senha é obrigatória');
        
        if (!$validator->isValid()) {
            Session::flash('error', 'Dados inválidos: ' . implode(', ', array_map(fn($errors) => $errors[0], $validator->getErrors())));
            $this->redirect('/login');
        }
        
        $user = $this->userModel->authenticate($input['email'], $input['senha']);
        
        if (!$user) {
            Session::flash('error', 'Email ou senha incorretos.');
            $this->redirect('/login');
        }
        
        // Buscar dados do perfil
        $userWithProfile = $this->userModel->getUserWithProfile($user['id']);
        
        Session::login($user['id'], $userWithProfile['perfil'] ?? 'Usuário', [
            'nome' => $user['nome'],
            'sobrenome' => $user['sobrenome'],
            'email' => $user['email']
        ]);
        
        Session::flash('success', 'Login realizado com sucesso!');
        $this->redirect('/dashboard');
    }
    
    public function showRegister(): void
    {
        if (Session::isLoggedIn()) {
            $this->redirect('/dashboard');
        }
        
        $this->view('auth/register', [
            'csrf_token' => $this->generateCsrfToken(),
            'error' => Session::getFlash('error'),
            'success' => Session::getFlash('success')
        ]);
    }
    
    public function register(): void
    {
        $input = $this->sanitizeInput($this->getInput());
        
        if (!$this->validateCsrf()) {
            Session::flash('error', 'Token de segurança inválido.');
            $this->redirect('/register');
        }
        
        $validator = new Validator($input);
        $validator->required('nome', 'Nome é obrigatório')
                 ->required('sobrenome', 'Sobrenome é obrigatório')
                 ->required('email', 'Email é obrigatório')
                 ->email('email', 'Email deve ser válido')
                 ->required('senha', 'Senha é obrigatória')
                 ->min('senha', 6, 'Senha deve ter pelo menos 6 caracteres')
                 ->required('confirmar_senha', 'Confirmação de senha é obrigatória')
                 ->cpf('cpf', 'CPF deve ser válido')
                 ->date('dt_nascimento', 'Data de nascimento deve ser válida')
                 ->in('sexo', ['Masc', 'Fem'], 'Sexo deve ser Masculino ou Feminino');
        
        if (!$validator->isValid()) {
            Session::flash('error', 'Dados inválidos: ' . implode(', ', array_map(fn($errors) => $errors[0], $validator->getErrors())));
            $this->redirect('/register');
        }
        
        if ($input['senha'] !== $input['confirmar_senha']) {
            Session::flash('error', 'Senhas não coincidem.');
            $this->redirect('/register');
        }
        
        // Verificar se email já existe
        if ($this->userModel->findByEmail($input['email'])) {
            Session::flash('error', 'Este email já está cadastrado.');
            $this->redirect('/register');
        }
        
        try {
            $userId = $this->userModel->createUser([
                'nome' => $input['nome'],
                'sobrenome' => $input['sobrenome'],
                'email' => $input['email'],
                'senha' => $input['senha'],
                'cpf' => $input['cpf'],
                'dt_nascimento' => $input['dt_nascimento'],
                'sexo' => $input['sexo'],
                'endereco' => $input['endereco'] ?? ''
            ]);
            
            Session::flash('success', 'Cadastro realizado com sucesso! Faça login para continuar.');
            $this->redirect('/login');
            
        } catch (\Exception $e) {
            Session::flash('error', 'Erro ao criar usuário: ' . $e->getMessage());
            $this->redirect('/register');
        }
    }
    
    public function logout(): void
    {
        Session::logout();
        Session::flash('success', 'Logout realizado com sucesso!');
        $this->redirect('/');
    }
    
    public function showProfile(): void
    {
        $this->requireAuth();
        
        $userId = Session::getUserId();
        $user = $this->userModel->getUserWithProfile($userId);
        
        $this->view('auth/profile', [
            'user' => $user,
            'csrf_token' => $this->generateCsrfToken(),
            'error' => Session::getFlash('error'),
            'success' => Session::getFlash('success')
        ]);
    }
    
    public function updateProfile(): void
    {
        $this->requireAuth();
        
        $input = $this->sanitizeInput($this->getInput());
        
        if (!$this->validateCsrf()) {
            Session::flash('error', 'Token de segurança inválido.');
            $this->redirect('/profile');
        }
        
        $validator = new Validator($input);
        $validator->required('nome', 'Nome é obrigatório')
                 ->required('sobrenome', 'Sobrenome é obrigatório')
                 ->required('email', 'Email é obrigatório')
                 ->email('email', 'Email deve ser válido')
                 ->cpf('cpf', 'CPF deve ser válido')
                 ->date('dt_nascimento', 'Data de nascimento deve ser válida')
                 ->in('sexo', ['Masc', 'Fem'], 'Sexo deve ser Masculino ou Feminino');
        
        if (!$validator->isValid()) {
            Session::flash('error', 'Dados inválidos: ' . implode(', ', array_map(fn($errors) => $errors[0], $validator->getErrors())));
            $this->redirect('/profile');
        }
        
        $userId = Session::getUserId();
        
        // Verificar se email já existe para outro usuário
        $existingUser = $this->userModel->findByEmail($input['email']);
        if ($existingUser && $existingUser['id'] != $userId) {
            Session::flash('error', 'Este email já está sendo usado por outro usuário.');
            $this->redirect('/profile');
        }
        
        try {
            $this->userModel->update($userId, [
                'nome' => $input['nome'],
                'sobrenome' => $input['sobrenome'],
                'email' => $input['email'],
                'cpf' => $input['cpf'],
                'dt_nascimento' => $input['dt_nascimento'],
                'sexo' => $input['sexo'],
                'endereco' => $input['endereco'] ?? ''
            ]);
            
            Session::flash('success', 'Perfil atualizado com sucesso!');
            $this->redirect('/profile');
            
        } catch (\Exception $e) {
            Session::flash('error', 'Erro ao atualizar perfil: ' . $e->getMessage());
            $this->redirect('/profile');
        }
    }
}

