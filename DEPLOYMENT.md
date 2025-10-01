# Guia de Deploy - SmartSecurity Laravel

## Preparação para Produção

### Configuração do Servidor

O sistema SmartSecurity refatorado requer um servidor web moderno com suporte a PHP 8.1+ e banco de dados. As configurações recomendadas incluem um servidor Linux Ubuntu 22.04 LTS ou superior, com pelo menos 2GB de RAM e 20GB de espaço em disco.

Para a instalação do ambiente, é necessário configurar o PHP 8.1 com as extensões essenciais. O comando de instalação no Ubuntu seria:

```bash
sudo apt update
sudo apt install -y php8.1 php8.1-cli php8.1-fpm php8.1-mysql php8.1-sqlite3 php8.1-zip php8.1-gd php8.1-mbstring php8.1-curl php8.1-xml php8.1-bcmath php8.1-intl
```

O Composer deve ser instalado globalmente para gerenciar as dependências PHP, enquanto o Node.js 18+ é necessário para compilar os assets frontend.

### Configuração do Banco de Dados

Para ambientes de produção, recomenda-se o uso do MySQL 8.0 ou PostgreSQL 13+. A configuração do banco deve incluir a criação de um usuário específico para a aplicação com permissões limitadas apenas ao banco de dados do SmartSecurity.

Exemplo de configuração MySQL:

```sql
CREATE DATABASE smartsecurity_prod CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'smartsecurity'@'localhost' IDENTIFIED BY 'senha_segura_aqui';
GRANT ALL PRIVILEGES ON smartsecurity_prod.* TO 'smartsecurity'@'localhost';
FLUSH PRIVILEGES;
```

### Configuração do Servidor Web

#### Nginx (Recomendado)

A configuração do Nginx deve incluir suporte a PHP-FPM e regras de reescrita para o Laravel. O arquivo de configuração típico seria:

```nginx
server {
    listen 80;
    server_name smartsecurity.exemplo.com;
    root /var/www/smartsecurity/public;
    
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\.ht {
        deny all;
    }
}
```

#### Apache

Para servidores Apache, o arquivo .htaccess já está configurado no diretório public. É necessário apenas habilitar o mod_rewrite:

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

## Processo de Deploy

### Preparação dos Arquivos

O primeiro passo é clonar ou transferir os arquivos do projeto para o servidor. Recomenda-se usar Git para facilitar atualizações futuras:

```bash
cd /var/www
sudo git clone [repository-url] smartsecurity
sudo chown -R www-data:www-data smartsecurity
```

### Instalação das Dependências

As dependências PHP devem ser instaladas sem as dependências de desenvolvimento:

```bash
cd /var/www/smartsecurity
composer install --no-dev --optimize-autoloader
```

Para as dependências JavaScript e compilação dos assets:

```bash
npm ci
npm run build
```

### Configuração do Ambiente

O arquivo .env deve ser configurado especificamente para produção:

```env
APP_NAME="SmartSecurity"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://smartsecurity.exemplo.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smartsecurity_prod
DB_USERNAME=smartsecurity
DB_PASSWORD=senha_segura_aqui

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

MAIL_MAILER=smtp
MAIL_HOST=smtp.exemplo.com
MAIL_PORT=587
MAIL_USERNAME=noreply@smartsecurity.exemplo.com
MAIL_PASSWORD=senha_email
MAIL_ENCRYPTION=tls
```

### Execução das Migrations

As migrations devem ser executadas para criar a estrutura do banco de dados:

```bash
php artisan migrate --force
php artisan db:seed --class=ProfileSeeder
```

### Configuração de Permissões

As permissões corretas devem ser definidas para os diretórios de storage e cache:

```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### Otimizações de Performance

Para ambientes de produção, várias otimizações devem ser aplicadas:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

## Configuração de SSL/HTTPS

### Certificado SSL

Para produção, é essencial configurar HTTPS. Recomenda-se usar Let's Encrypt com Certbot:

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d smartsecurity.exemplo.com
```

### Redirecionamento HTTPS

A configuração do Nginx deve incluir redirecionamento automático para HTTPS:

```nginx
server {
    listen 80;
    server_name smartsecurity.exemplo.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name smartsecurity.exemplo.com;
    
    ssl_certificate /etc/letsencrypt/live/smartsecurity.exemplo.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/smartsecurity.exemplo.com/privkey.pem;
    
    # Resto da configuração...
}
```

## Monitoramento e Logs

### Configuração de Logs

O Laravel deve ser configurado para usar logs rotativos em produção:

```php
// config/logging.php
'channels' => [
    'daily' => [
        'driver' => 'daily',
        'path' => storage_path('logs/laravel.log'),
        'level' => 'error',
        'days' => 14,
    ],
],
```

### Monitoramento de Performance

Recomenda-se implementar monitoramento com ferramentas como New Relic, Datadog ou soluções open-source como Prometheus + Grafana.

### Backup Automatizado

Um script de backup deve ser configurado para executar diariamente:

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backups/smartsecurity"

# Backup do banco de dados
mysqldump -u smartsecurity -p smartsecurity_prod > $BACKUP_DIR/db_$DATE.sql

# Backup dos arquivos
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/smartsecurity/storage/app/public

# Manter apenas os últimos 7 backups
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete
```

## Atualizações e Manutenção

### Processo de Atualização

Para atualizações do sistema, recomenda-se o seguinte processo:

1. Backup completo do sistema e banco de dados
2. Ativação do modo de manutenção: `php artisan down`
3. Pull das atualizações do repositório Git
4. Atualização das dependências: `composer install --no-dev`
5. Execução de novas migrations: `php artisan migrate --force`
6. Recompilação dos assets: `npm run build`
7. Limpeza e recriação dos caches
8. Desativação do modo de manutenção: `php artisan up`

### Manutenção Preventiva

Tarefas de manutenção devem ser agendadas via cron:

```bash
# Limpeza de logs antigos
0 2 * * * find /var/www/smartsecurity/storage/logs -name "*.log" -mtime +30 -delete

# Limpeza de sessões expiradas
0 3 * * * php /var/www/smartsecurity/artisan session:gc

# Backup diário
0 1 * * * /scripts/backup_smartsecurity.sh
```

## Segurança

### Configurações de Segurança

Várias configurações de segurança devem ser implementadas:

- Firewall configurado para permitir apenas portas 80, 443 e SSH
- Fail2ban configurado para proteção contra ataques de força bruta
- Atualizações automáticas de segurança habilitadas
- Usuário específico para a aplicação sem privilégios de sudo

### Headers de Segurança

O servidor web deve ser configurado com headers de segurança apropriados:

```nginx
add_header X-Frame-Options "SAMEORIGIN" always;
add_header X-XSS-Protection "1; mode=block" always;
add_header X-Content-Type-Options "nosniff" always;
add_header Referrer-Policy "no-referrer-when-downgrade" always;
add_header Content-Security-Policy "default-src 'self' http: https: data: blob: 'unsafe-inline'" always;
```

## Troubleshooting

### Problemas Comuns

**Erro 500 - Internal Server Error**: Verificar logs do Laravel em `storage/logs/laravel.log` e logs do servidor web. Geralmente relacionado a permissões incorretas ou configuração do .env.

**Assets não carregam**: Verificar se o comando `npm run build` foi executado e se os arquivos estão no diretório `public/build`.

**Erro de conexão com banco**: Verificar credenciais no .env e conectividade com o servidor de banco de dados.

### Logs Importantes

- Laravel: `/var/www/smartsecurity/storage/logs/laravel.log`
- Nginx: `/var/log/nginx/error.log` e `/var/log/nginx/access.log`
- PHP-FPM: `/var/log/php8.1-fpm.log`

## Conclusão

Este guia fornece uma base sólida para o deploy do SmartSecurity em ambiente de produção. A implementação adequada dessas configurações garante um sistema seguro, performático e confiável para servir a comunidade de Ceilândia e região.

Para suporte adicional ou dúvidas específicas sobre o deploy, consulte a documentação oficial do Laravel ou entre em contato com a equipe de desenvolvimento.

---

**Autor**: Manus AI  
**Data**: Outubro 2025  
**Versão**: 1.0
