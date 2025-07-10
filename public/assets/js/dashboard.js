// Dashboard JavaScript - SmartSecurity

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar gráficos
    initializeCharts();
    
    // Atualizar dados a cada 5 minutos
    setInterval(updateDashboardData, 300000);
});

function initializeCharts() {
    // Gráfico de tendência mensal
    const monthlyCtx = document.getElementById('monthlyChart');
    if (monthlyCtx && typeof monthlyData !== 'undefined') {
        createMonthlyChart(monthlyCtx);
    }
    
    // Gráfico de localizações
    const locationCtx = document.getElementById('locationChart');
    if (locationCtx && typeof locationData !== 'undefined') {
        createLocationChart(locationCtx);
    }
}

function createMonthlyChart(ctx) {
    const labels = monthlyData.map(item => {
        const [year, month] = item.month.split('-');
        return new Date(year, month - 1).toLocaleDateString('pt-BR', { 
            month: 'short', 
            year: 'numeric' 
        });
    }).reverse();
    
    const totalData = monthlyData.map(item => item.total).reverse();
    const assaultData = monthlyData.map(item => item.assaults).reverse();
    const lossData = monthlyData.map(item => item.losses).reverse();
    
    const data = {
        labels: labels,
        datasets: [
            {
                label: 'Total',
                data: totalData,
                borderColor: SmartSecurity.config.chartColors.primary,
                backgroundColor: SmartSecurity.config.chartColors.primary + '20',
                tension: 0.4,
                fill: true
            },
            {
                label: 'Assaltos',
                data: assaultData,
                borderColor: SmartSecurity.config.chartColors.danger,
                backgroundColor: SmartSecurity.config.chartColors.danger + '20',
                tension: 0.4
            },
            {
                label: 'Perdas',
                data: lossData,
                borderColor: SmartSecurity.config.chartColors.warning,
                backgroundColor: SmartSecurity.config.chartColors.warning + '20',
                tension: 0.4
            }
        ]
    };
    
    const options = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: 'Ocorrências por Mês'
            },
            legend: {
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        },
        interaction: {
            intersect: false,
            mode: 'index'
        }
    };
    
    new Chart(ctx, {
        type: 'line',
        data: data,
        options: options
    });
}

function createLocationChart(ctx) {
    const labels = locationData.map(item => {
        // Truncar nomes muito longos
        const location = item.localizacao;
        return location.length > 20 ? location.substring(0, 20) + '...' : location;
    });
    
    const totalData = locationData.map(item => item.total);
    const assaultData = locationData.map(item => item.assaults);
    const lossData = locationData.map(item => item.losses);
    
    const data = {
        labels: labels,
        datasets: [
            {
                label: 'Assaltos',
                data: assaultData,
                backgroundColor: SmartSecurity.config.chartColors.danger,
                borderColor: SmartSecurity.config.chartColors.danger,
                borderWidth: 1
            },
            {
                label: 'Perdas',
                data: lossData,
                backgroundColor: SmartSecurity.config.chartColors.warning,
                borderColor: SmartSecurity.config.chartColors.warning,
                borderWidth: 1
            }
        ]
    };
    
    const options = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: 'Top 10 Locais com Mais Ocorrências'
            },
            legend: {
                position: 'top'
            }
        },
        scales: {
            x: {
                ticks: {
                    maxRotation: 45,
                    minRotation: 45
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    };
    
    new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });
}

async function updateDashboardData() {
    try {
        const response = await SmartSecurity.utils.ajax('/api/statistics');
        
        if (response.success) {
            // Atualizar cards de estatísticas
            updateStatCards(response.data);
            
            // Mostrar notificação de atualização
            SmartSecurity.notifications.show('Dados atualizados!', 'success', 2000);
        }
    } catch (error) {
        console.error('Erro ao atualizar dados:', error);
    }
}

function updateStatCards(data) {
    // Atualizar números nos cards de estatísticas
    const totalElement = document.querySelector('.card-stats .display-4');
    if (totalElement && data.occurrence_stats) {
        totalElement.textContent = SmartSecurity.utils.formatNumber(data.occurrence_stats.total_occurrences);
    }
    
    // Adicionar animação de atualização
    const cards = document.querySelectorAll('.card-stats');
    cards.forEach(card => {
        card.classList.add('updated');
        setTimeout(() => {
            card.classList.remove('updated');
        }, 1000);
    });
}

// Adicionar estilos para animação de atualização
const style = document.createElement('style');
style.textContent = `
    .card-stats.updated {
        transform: scale(1.02);
        transition: transform 0.3s ease;
    }
    
    .chart-container {
        position: relative;
        height: 400px;
    }
    
    @media (max-width: 768px) {
        .chart-container {
            height: 300px;
        }
    }
`;
document.head.appendChild(style);

