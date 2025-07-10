<?php
$pageTitle = 'Dashboard - SmartSecurity';
$pageDescription = 'Painel de controle do SmartSecurity com estatísticas e suas ocorrências.';
$bodyClass = 'dashboard-page';
$customJS = ['/assets/js/dashboard.js'];

ob_start();
?>

<div class="container-fluid py-4">
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold mb-1">
                        Olá, <?= htmlspecialchars($user['nome']) ?>! 👋
                    </h1>
                    <p class="text-muted mb-0">
                        Bem-vindo ao seu dashboard. Aqui você pode acompanhar estatísticas e gerenciar suas ocorrências.
                    </p>
                </div>
                <div>
                    <a href="/occurrences/create" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Nova Ocorrência
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="display-4 fw-bold mb-0">
                                <?= number_format($occurrenceStats['total_occurrences']) ?>
                            </h3>
                            <p class="mb-0">Total de Ocorrências</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-exclamation-triangle fa-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-stats bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="display-4 fw-bold mb-0">
                                <?= number_format($occurrenceStats['assaults']) ?>
                            </h3>
                            <p class="mb-0">Assaltos</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-mask fa-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-stats bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="display-4 fw-bold mb-0">
                                <?= number_format($occurrenceStats['losses']) ?>
                            </h3>
                            <p class="mb-0">Perdas</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-mobile-alt fa-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-stats bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="display-4 fw-bold mb-0">
                                <?= number_format($userOccurrenceCount) ?>
                            </h3>
                            <p class="mb-0">Suas Ocorrências</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-user fa-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Charts Column -->
        <div class="col-lg-8">
            <!-- Monthly Trends Chart -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2"></i>Tendência Mensal
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Location Stats Chart -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>Ocorrências por Localização
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="locationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Column -->
        <div class="col-lg-4">
            <!-- Recent Activity -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clock me-2"></i>Atividade Recente
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($recentOccurrences)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach (array_slice($recentOccurrences, 0, 5) as $occurrence): ?>
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1"><?= htmlspecialchars($occurrence['titulo_registro']) ?></h6>
                                            <p class="mb-1 text-muted small">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                <?= htmlspecialchars($occurrence['localizacao']) ?>
                                            </p>
                                            <small class="text-muted">
                                                <?= date('d/m/Y H:i', strtotime($occurrence['dt_registro'] . ' ' . $occurrence['hr_registro'])) ?>
                                            </small>
                                        </div>
                                        <span class="badge bg-<?= $occurrence['tipo'] === 'Assalto' ? 'danger' : 'warning' ?>">
                                            <?= htmlspecialchars($occurrence['tipo']) ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="text-center mt-3">
                            <a href="/search" class="btn btn-outline-primary btn-sm">
                                Ver Todas
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p>Nenhuma atividade recente</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>Ações Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="/occurrences/create" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Reportar Ocorrência
                        </a>
                        <a href="/occurrences" class="btn btn-outline-primary">
                            <i class="fas fa-list me-2"></i>Minhas Ocorrências
                        </a>
                        <a href="/search" class="btn btn-outline-secondary">
                            <i class="fas fa-search me-2"></i>Buscar Ocorrências
                        </a>
                        <a href="/profile" class="btn btn-outline-info">
                            <i class="fas fa-user-edit me-2"></i>Editar Perfil
                        </a>
                    </div>
                </div>
            </div>

            <!-- Safety Tips -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-lightbulb me-2"></i>Dicas de Segurança
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <strong>💡 Dica do Dia:</strong>
                        <p class="mb-0 mt-2">
                            Evite usar o celular em locais públicos com pouco movimento. 
                            Mantenha-se sempre atento ao ambiente ao seu redor.
                        </p>
                    </div>
                    
                    <div class="mt-3">
                        <h6>Locais com Maior Risco:</h6>
                        <ul class="list-unstyled">
                            <?php foreach (array_slice($locationStats, 0, 3) as $location): ?>
                                <li class="mb-1">
                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                    <?= htmlspecialchars($location['localizacao']) ?>
                                    <span class="badge bg-danger ms-2"><?= $location['total'] ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Section -->
    <?php if ($userRole === 'Administrador'): ?>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cog me-2"></i>Painel Administrativo
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="text-center">
                                <h4 class="text-primary"><?= number_format($userStats['total_users']) ?></h4>
                                <small class="text-muted">Total de Usuários</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h4 class="text-success"><?= number_format($userStats['regular_users']) ?></h4>
                                <small class="text-muted">Usuários Regulares</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h4 class="text-info"><?= number_format($userStats['admins']) ?></h4>
                                <small class="text-muted">Administradores</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <a href="/admin" class="btn btn-dark">
                                    <i class="fas fa-tools me-2"></i>Administração
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
// Dados para os gráficos
const monthlyData = <?= json_encode($monthlyStats) ?>;
const locationData = <?= json_encode(array_slice($locationStats, 0, 10)) ?>;
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
?>

