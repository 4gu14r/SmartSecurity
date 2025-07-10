<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $pageDescription ?? 'SmartSecurity - Sistema de monitoramento de segurança pública' ?>">
    <meta name="keywords" content="segurança, ocorrências, assaltos, celular perdido, Ceilândia">
    <meta name="author" content="SmartSecurity">
    
    <title><?= $pageTitle ?? 'SmartSecurity' ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/icons/favicon.ico">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/app.css" rel="stylesheet">
    
    <!-- Chart.js para gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Custom CSS -->
    <?php if (isset($customCSS)): ?>
        <?php foreach ($customCSS as $css): ?>
            <link href="<?= $css ?>" rel="stylesheet">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body class="<?= $bodyClass ?? '' ?>">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <i class="fas fa-shield-alt me-2"></i>
                SmartSecurity
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            <i class="fas fa-home me-1"></i>Início
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/search">
                            <i class="fas fa-search me-1"></i>Buscar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/statistics">
                            <i class="fas fa-chart-bar me-1"></i>Estatísticas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about">
                            <i class="fas fa-info-circle me-1"></i>Sobre
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <?php if (\SmartSecurity\Utils\Session::isLoggedIn()): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>
                                <?= htmlspecialchars(\SmartSecurity\Utils\Session::get('user_data')['nome'] ?? 'Usuário') ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/dashboard">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a></li>
                                <li><a class="dropdown-item" href="/profile">
                                    <i class="fas fa-user-edit me-2"></i>Perfil
                                </a></li>
                                <li><a class="dropdown-item" href="/occurrences">
                                    <i class="fas fa-exclamation-triangle me-2"></i>Minhas Ocorrências
                                </a></li>
                                <?php if (\SmartSecurity\Utils\Session::getUserRole() === 'Administrador'): ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="/admin">
                                        <i class="fas fa-cog me-2"></i>Administração
                                    </a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/logout">
                                    <i class="fas fa-sign-out-alt me-2"></i>Sair
                                </a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/login">
                                <i class="fas fa-sign-in-alt me-1"></i>Entrar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/register">
                                <i class="fas fa-user-plus me-1"></i>Cadastrar
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <?php 
    $success = \SmartSecurity\Utils\Session::getFlash('success');
    $error = \SmartSecurity\Utils\Session::getFlash('error');
    $warning = \SmartSecurity\Utils\Session::getFlash('warning');
    $info = \SmartSecurity\Utils\Session::getFlash('info');
    ?>
    
    <?php if ($success): ?>
        <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= htmlspecialchars($success) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if ($warning): ?>
        <div class="alert alert-warning alert-dismissible fade show m-0" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= htmlspecialchars($warning) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if ($info): ?>
        <div class="alert alert-info alert-dismissible fade show m-0" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            <?= htmlspecialchars($info) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="<?= $mainClass ?? '' ?>">
        <?= $content ?? '' ?>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-shield-alt me-2"></i>SmartSecurity</h5>
                    <p class="mb-0">Sistema de monitoramento de segurança pública para Ceilândia e região.</p>
                </div>
                <div class="col-md-3">
                    <h6>Links Úteis</h6>
                    <ul class="list-unstyled">
                        <li><a href="/about" class="text-light text-decoration-none">Sobre Nós</a></li>
                        <li><a href="/contact" class="text-light text-decoration-none">Contato</a></li>
                        <li><a href="/statistics" class="text-light text-decoration-none">Estatísticas</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Legal</h6>
                    <ul class="list-unstyled">
                        <li><a href="/privacy" class="text-light text-decoration-none">Política de Privacidade</a></li>
                        <li><a href="/terms" class="text-light text-decoration-none">Termos de Uso</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; <?= date('Y') ?> SmartSecurity. Todos os direitos reservados.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <button id="darkModeToggle" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-moon"></i> Modo Escuro
                    </button>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/app.js"></script>
    
    <!-- Custom JavaScript -->
    <?php if (isset($customJS)): ?>
        <?php foreach ($customJS as $js): ?>
            <script src="<?= $js ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Inline JavaScript -->
    <?php if (isset($inlineJS)): ?>
        <script><?= $inlineJS ?></script>
    <?php endif; ?>
</body>
</html>

