<?php
$pageTitle = 'Cadastro - SmartSecurity';
$pageDescription = 'Crie sua conta no SmartSecurity para acessar seu dashboard e reportar ocorrências.';
$bodyClass = 'auth-page';

ob_start();
?>

<div class="container-fluid">
    <div class="row min-vh-100">
        <!-- Left Side - Register Form -->
        <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="w-100" style="max-width: 400px;">
                <div class="text-center mb-4">
                    <h1 class="h3 fw-bold text-primary">
                        <i class="fas fa-shield-alt me-2"></i>SmartSecurity
                    </h1>
                    <p class="text-muted">Crie sua conta</p>
                </div>

                <form method="POST" action="/register" class="needs-validation" novalidate>
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>
                        <label for="nome">
                            <i class="fas fa-user me-2"></i>Nome
                        </label>
                        <div class="invalid-feedback">
                            Por favor, insira seu nome.
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Sobrenome" required>
                        <label for="sobrenome">
                            <i class="fas fa-user me-2"></i>Sobrenome
                        </label>
                        <div class="invalid-feedback">
                            Por favor, insira seu sobrenome.
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="seu@email.com" required>
                        <label for="email">
                            <i class="fas fa-envelope me-2"></i>Email
                        </label>
                        <div class="invalid-feedback">
                            Por favor, insira um email válido.
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required minlength="6">
                        <label for="senha">
                            <i class="fas fa-lock me-2"></i>Senha
                        </label>
                        <div class="invalid-feedback">
                            Por favor, insira uma senha com no mínimo 6 caracteres.
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" placeholder="Confirme a senha" required minlength="6">
                        <label for="confirmar_senha">
                            <i class="fas fa-lock me-2"></i>Confirmar Senha
                        </label>
                        <div class="invalid-feedback">
                            Por favor, confirme sua senha.
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">
                        <i class="fas fa-user-plus me-2"></i>Cadastrar
                    </button>

                    <div class="text-center">
                        <p class="mb-0">
                            Já tem uma conta? 
                            <a href="/login" class="text-decoration-none fw-bold">
                                Faça login aqui
                            </a>
                        </p>
                    </div>
                </form>

                <hr class="my-4">

                <div class="text-center">
                    <p class="text-muted mb-2">Ou continue como:</p>
                    <a href="/search" class="btn btn-outline-secondary">
                        <i class="fas fa-eye me-2"></i>Visitante
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Side - Hero Image -->
        <div class="col-lg-6 d-none d-lg-block position-relative">
            <div class="h-100 d-flex align-items-center justify-content-center bg-primary">
                <div class="text-center text-white p-5">
                    <img src="/assets/img/mobile-app.jpg" alt="SmartSecurity App" 
                         class="img-fluid rounded shadow-lg mb-4" style="max-height: 300px;">
                    
                    <h2 class="display-6 fw-bold mb-3">Segurança Colaborativa</h2>
                    <p class="lead mb-4">
                        Junte-se à nossa comunidade e ajude a tornar Ceilândia mais segura. 
                        Reporte ocorrências, consulte estatísticas e mantenha-se informado.
                    </p>
                    
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="mb-2">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                            <small>Comunidade Ativa</small>
                        </div>
                        <div class="col-4">
                            <div class="mb-2">
                                <i class="fas fa-chart-line fa-2x"></i>
                            </div>
                            <small>Dados em Tempo Real</small>
                        </div>
                        <div class="col-4">
                            <div class="mb-2">
                                <i class="fas fa-shield-alt fa-2x"></i>
                            </div>
                            <small>Segurança Garantida</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.auth-page {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.auth-page .form-floating > label {
    padding-left: 2.5rem;
}

.auth-page .form-control {
    padding-left: 2.5rem;
}

.auth-page .form-floating > label i {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
}

@media (max-width: 991.98px) {
    .auth-page {
        background: white;
    }
}
</style>

<script>
// Exemplo simples de validação front-end para confirmação de senha
(() => {
    'use strict'

    const form = document.querySelector('form.needs-validation');

    form.addEventListener('submit', event => {
        const senha = form.querySelector('#senha');
        const confirmar = form.querySelector('#confirmar_senha');

        if (senha.value !== confirmar.value) {
            confirmar.setCustomValidity('As senhas não conferem');
        } else {
            confirmar.setCustomValidity('');
        }

        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }

        form.classList.add('was-validated');
    }, false);
})();
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
?>
