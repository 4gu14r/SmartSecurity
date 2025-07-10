<?php
$pageTitle = 'SmartSecurity - Segurança Inteligente para Ceilândia';
$pageDescription = 'Sistema colaborativo de monitoramento de segurança pública para Ceilândia e região. Reporte ocorrências, consulte estatísticas e ajude a tornar nossa comunidade mais segura.';
$bodyClass = 'home-page';

ob_start();
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6 fade-in">
                <h1 class="display-4 fw-bold mb-4">
                    Segurança Inteligente para 
                    <span class="text-gradient">Ceilândia</span>
                </h1>
                <p class="lead mb-4">
                    Juntos, criamos uma rede colaborativa de segurança pública. 
                    Reporte ocorrências, consulte estatísticas em tempo real e 
                    ajude a tornar nossa comunidade mais segura.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <?php if (!$isLoggedIn): ?>
                        <a href="/register" class="btn btn-gradient btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Cadastre-se Grátis
                        </a>
                        <a href="/login" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Entrar
                        </a>
                    <?php else: ?>
                        <a href="/dashboard" class="btn btn-gradient btn-lg">
                            <i class="fas fa-tachometer-alt me-2"></i>Acessar Dashboard
                        </a>
                        <a href="/occurrences/create" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-plus me-2"></i>Reportar Ocorrência
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6 text-center slide-in-right">
                <img src="/assets/img/dashboard-hero.jpg" alt="Dashboard SmartSecurity" 
                     class="img-fluid rounded shadow-lg" style="max-height: 500px;">
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="display-5 fw-bold mb-3">Estatísticas em Tempo Real</h2>
                <p class="lead text-muted">Dados atualizados da nossa comunidade</p>
            </div>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card fade-in">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-number"><?= number_format($stats['total_occurrences'] ?? 0) ?></div>
                <div class="stat-label">Total de Ocorrências</div>
            </div>
            
            <div class="stat-card fade-in" style="animation-delay: 0.1s;">
                <div class="stat-icon">
                    <i class="fas fa-mask"></i>
                </div>
                <div class="stat-number"><?= number_format($stats['assaults'] ?? 0) ?></div>
                <div class="stat-label">Assaltos Reportados</div>
            </div>
            
            <div class="stat-card fade-in" style="animation-delay: 0.2s;">
                <div class="stat-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <div class="stat-number"><?= number_format($stats['losses'] ?? 0) ?></div>
                <div class="stat-label">Celulares Perdidos</div>
            </div>
            
            <div class="stat-card fade-in" style="animation-delay: 0.3s;">
                <div class="stat-icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="stat-number"><?= number_format($stats['today'] ?? 0) ?></div>
                <div class="stat-label">Hoje</div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="display-5 fw-bold mb-3">Como Funciona</h2>
                <p class="lead text-muted">Tecnologia a serviço da segurança pública</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4 fade-in">
                <div class="card h-100 border-0 shadow">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-mobile-alt fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title">Reporte Facilmente</h5>
                        <p class="card-text">
                            Interface intuitiva para reportar ocorrências rapidamente. 
                            Adicione localização, fotos e descrição detalhada.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 fade-in" style="animation-delay: 0.1s;">
                <div class="card h-100 border-0 shadow">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-chart-line fa-3x text-success"></i>
                        </div>
                        <h5 class="card-title">Análise Inteligente</h5>
                        <p class="card-text">
                            Algoritmos avançados analisam padrões e geram 
                            estatísticas úteis para autoridades e comunidade.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 fade-in" style="animation-delay: 0.2s;">
                <div class="card h-100 border-0 shadow">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-shield-alt fa-3x text-info"></i>
                        </div>
                        <h5 class="card-title">Comunidade Segura</h5>
                        <p class="card-text">
                            Informação compartilhada gera prevenção. 
                            Juntos, criamos uma rede de proteção eficaz.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Recent Occurrences Section -->
<?php if (!empty($recentOccurrences)): ?>
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="display-6 fw-bold mb-3">Ocorrências Recentes</h2>
                <p class="text-muted">Últimos relatos da comunidade</p>
            </div>
        </div>
        
        <div class="row g-4">
            <?php foreach ($recentOccurrences as $occurrence): ?>
                <div class="col-md-4 fade-in">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-<?= $occurrence['tipo'] === 'Assalto' ? 'danger' : 'warning' ?>">
                                    <?= htmlspecialchars($occurrence['tipo']) ?>
                                </span>
                                <small class="text-muted">
                                    <?= date('d/m/Y', strtotime($occurrence['dt_registro'])) ?>
                                </small>
                            </div>
                            <h6 class="card-title"><?= htmlspecialchars($occurrence['titulo_registro']) ?></h6>
                            <p class="card-text text-muted small">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                <?= htmlspecialchars($occurrence['localizacao']) ?>
                            </p>
                            <p class="card-text">
                                <?= htmlspecialchars(substr($occurrence['descricao'], 0, 100)) ?>
                                <?= strlen($occurrence['descricao']) > 100 ? '...' : '' ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="/search" class="btn btn-primary">
                <i class="fas fa-search me-2"></i>Ver Todas as Ocorrências
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Location Stats Section -->
<?php if (!empty($locationStats)): ?>
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="display-6 fw-bold mb-3">Locais com Mais Ocorrências</h2>
                <p class="text-muted">Áreas que requerem maior atenção</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-8">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Localização</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Assaltos</th>
                                <th class="text-center">Perdas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($locationStats, 0, 5) as $location): ?>
                                <tr>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                        <?= htmlspecialchars($location['localizacao']) ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary"><?= $location['total'] ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-danger"><?= $location['assaults'] ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-warning"><?= $location['losses'] ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Dica de Segurança</h5>
                        <i class="fas fa-lightbulb fa-3x text-warning mb-3"></i>
                        <p class="card-text">
                            Evite locais com alto índice de ocorrências, 
                            especialmente durante horários de pico. 
                            Mantenha-se sempre alerta!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Call to Action Section -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="display-5 fw-bold mb-4">Faça Parte da Mudança</h2>
                <p class="lead mb-4">
                    Sua participação é fundamental para construirmos uma Ceilândia mais segura. 
                    Cada relato contribui para um mapeamento mais preciso da segurança pública.
                </p>
                <?php if (!$isLoggedIn): ?>
                    <a href="/register" class="btn btn-light btn-lg me-3">
                        <i class="fas fa-user-plus me-2"></i>Cadastre-se Agora
                    </a>
                    <a href="/about" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-info-circle me-2"></i>Saiba Mais
                    </a>
                <?php else: ?>
                    <a href="/occurrences/create" class="btn btn-light btn-lg me-3">
                        <i class="fas fa-plus me-2"></i>Reportar Ocorrência
                    </a>
                    <a href="/dashboard" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-tachometer-alt me-2"></i>Meu Dashboard
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
?>

