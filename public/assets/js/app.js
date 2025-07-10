// SmartSecurity - JavaScript Principal

// Configuração global
const SmartSecurity = {
    config: {
        apiUrl: '/api',
        chartColors: {
            primary: '#0d6efd',
            secondary: '#6c757d',
            success: '#198754',
            danger: '#dc3545',
            warning: '#ffc107',
            info: '#0dcaf0'
        }
    },
    
    // Utilitários
    utils: {
        // Formatar números
        formatNumber: (num) => {
            return new Intl.NumberFormat('pt-BR').format(num);
        },
        
        // Formatar data
        formatDate: (date) => {
            return new Intl.DateTimeFormat('pt-BR').format(new Date(date));
        },
        
        // Debounce para otimizar buscas
        debounce: (func, wait) => {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        },
        
        // Mostrar loading
        showLoading: (element) => {
            element.classList.add('loading');
            element.disabled = true;
        },
        
        // Esconder loading
        hideLoading: (element) => {
            element.classList.remove('loading');
            element.disabled = false;
        },
        
        // Fazer requisições AJAX
        ajax: async (url, options = {}) => {
            const defaultOptions = {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            };
            
            const config = { ...defaultOptions, ...options };
            
            try {
                const response = await fetch(url, config);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    return await response.json();
                }
                
                return await response.text();
            } catch (error) {
                console.error('Erro na requisição:', error);
                throw error;
            }
        }
    },
    
    // Módulo de notificações
    notifications: {
        show: (message, type = 'info', duration = 5000) => {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
            alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            
            const icons = {
                success: 'fas fa-check-circle',
                danger: 'fas fa-exclamation-circle',
                warning: 'fas fa-exclamation-triangle',
                info: 'fas fa-info-circle'
            };
            
            alertDiv.innerHTML = `
                <i class="${icons[type]} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(alertDiv);
            
            // Auto-remover após o tempo especificado
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, duration);
        }
    },
    
    // Módulo de gráficos
    charts: {
        // Gráfico de barras
        createBarChart: (ctx, data, options = {}) => {
            const defaultOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: options.title || 'Gráfico'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            };
            
            return new Chart(ctx, {
                type: 'bar',
                data: data,
                options: { ...defaultOptions, ...options }
            });
        },
        
        // Gráfico de linha
        createLineChart: (ctx, data, options = {}) => {
            const defaultOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: options.title || 'Gráfico'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            };
            
            return new Chart(ctx, {
                type: 'line',
                data: data,
                options: { ...defaultOptions, ...options }
            });
        },
        
        // Gráfico de pizza
        createPieChart: (ctx, data, options = {}) => {
            const defaultOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    title: {
                        display: true,
                        text: options.title || 'Gráfico'
                    }
                }
            };
            
            return new Chart(ctx, {
                type: 'pie',
                data: data,
                options: { ...defaultOptions, ...options }
            });
        }
    },
    
    // Módulo de busca
    search: {
        init: () => {
            const searchForm = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');
            const searchResults = document.getElementById('searchResults');
            
            if (searchForm && searchInput) {
                const debouncedSearch = SmartSecurity.utils.debounce(async (query) => {
                    if (query.length < 3) return;
                    
                    try {
                        SmartSecurity.utils.showLoading(searchInput);
                        
                        const results = await SmartSecurity.utils.ajax(`/search?q=${encodeURIComponent(query)}`);
                        
                        if (searchResults) {
                            SmartSecurity.search.displayResults(results, searchResults);
                        }
                    } catch (error) {
                        SmartSecurity.notifications.show('Erro ao buscar', 'danger');
                    } finally {
                        SmartSecurity.utils.hideLoading(searchInput);
                    }
                }, 300);
                
                searchInput.addEventListener('input', (e) => {
                    debouncedSearch(e.target.value);
                });
            }
        },
        
        displayResults: (results, container) => {
            if (!results || !results.results) return;
            
            container.innerHTML = '';
            
            if (results.results.length === 0) {
                container.innerHTML = '<p class="text-muted">Nenhum resultado encontrado.</p>';
                return;
            }
            
            results.results.forEach(result => {
                const resultDiv = document.createElement('div');
                resultDiv.className = 'card mb-3';
                resultDiv.innerHTML = `
                    <div class="card-body">
                        <h5 class="card-title">${result.titulo_registro}</h5>
                        <p class="card-text">${result.descricao || 'Sem descrição'}</p>
                        <small class="text-muted">
                            <i class="fas fa-map-marker-alt me-1"></i>${result.localizacao}
                            <i class="fas fa-calendar ms-3 me-1"></i>${SmartSecurity.utils.formatDate(result.dt_registro)}
                        </small>
                    </div>
                `;
                container.appendChild(resultDiv);
            });
        }
    },
    
    // Módulo de tema (dark mode)
    theme: {
        init: () => {
            const toggleButton = document.getElementById('darkModeToggle');
            const currentTheme = localStorage.getItem('theme') || 'light';
            
            // Aplicar tema salvo
            document.documentElement.setAttribute('data-theme', currentTheme);
            SmartSecurity.theme.updateToggleButton(toggleButton, currentTheme);
            
            if (toggleButton) {
                toggleButton.addEventListener('click', () => {
                    const currentTheme = document.documentElement.getAttribute('data-theme');
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    
                    document.documentElement.setAttribute('data-theme', newTheme);
                    localStorage.setItem('theme', newTheme);
                    SmartSecurity.theme.updateToggleButton(toggleButton, newTheme);
                });
            }
        },
        
        updateToggleButton: (button, theme) => {
            if (!button) return;
            
            const icon = button.querySelector('i');
            if (theme === 'dark') {
                icon.className = 'fas fa-sun';
                button.innerHTML = '<i class="fas fa-sun"></i> Modo Claro';
            } else {
                icon.className = 'fas fa-moon';
                button.innerHTML = '<i class="fas fa-moon"></i> Modo Escuro';
            }
        }
    },
    
    // Módulo de formulários
    forms: {
        init: () => {
            // Validação em tempo real
            const forms = document.querySelectorAll('.needs-validation');
            forms.forEach(form => {
                form.addEventListener('submit', (e) => {
                    if (!form.checkValidity()) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                    form.classList.add('was-validated');
                });
                
                // Validação em tempo real dos campos
                const inputs = form.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    input.addEventListener('blur', () => {
                        if (input.checkValidity()) {
                            input.classList.remove('is-invalid');
                            input.classList.add('is-valid');
                        } else {
                            input.classList.remove('is-valid');
                            input.classList.add('is-invalid');
                        }
                    });
                });
            });
            
            // Máscaras para campos
            SmartSecurity.forms.initMasks();
        },
        
        initMasks: () => {
            // Máscara para CPF
            const cpfInputs = document.querySelectorAll('input[data-mask="cpf"]');
            cpfInputs.forEach(input => {
                input.addEventListener('input', (e) => {
                    let value = e.target.value.replace(/\D/g, '');
                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                    e.target.value = value;
                });
            });
            
            // Máscara para telefone
            const phoneInputs = document.querySelectorAll('input[data-mask="phone"]');
            phoneInputs.forEach(input => {
                input.addEventListener('input', (e) => {
                    let value = e.target.value.replace(/\D/g, '');
                    value = value.replace(/(\d{2})(\d)/, '($1) $2');
                    value = value.replace(/(\d{4})(\d)/, '$1-$2');
                    value = value.replace(/(\d{4})-(\d)(\d{4})/, '$1$2-$3');
                    e.target.value = value;
                });
            });
        }
    }
};

// Inicialização quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', () => {
    // Inicializar módulos
    SmartSecurity.theme.init();
    SmartSecurity.search.init();
    SmartSecurity.forms.init();
    
    // Adicionar animações aos elementos
    const animatedElements = document.querySelectorAll('.fade-in, .slide-in-left, .slide-in-right');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateX(0) translateY(0)';
            }
        });
    });
    
    animatedElements.forEach(el => {
        el.style.opacity = '0';
        observer.observe(el);
    });
    
    // Auto-dismiss alerts após 5 segundos
    const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    });
    
    console.log('SmartSecurity inicializado com sucesso!');
});

// Exportar para uso global
window.SmartSecurity = SmartSecurity;

