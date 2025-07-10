# 🐳 SmartSecurity - Docker Setup

## 🚀 Execução Rápida com Docker

### Pré-requisitos
- Docker instalado
- Docker Compose instalado

### Comandos para Executar

```bash
# 1. Clonar/extrair o projeto
cd smartsecurity-modern

# 2. Copiar arquivo de ambiente para Docker
cp .env.docker .env

# 3. Subir os containers
docker-compose up -d

# 4. Aguardar inicialização (cerca de 30 segundos)
docker-compose logs -f

# 5. Acessar a aplicação
# Web: http://localhost
# phpMyAdmin: http://localhost:80
```

## 📋 Serviços Incluídos

### 🌐 Web (PHP + Apache)
- **Porta:** 80
- **URL:** http://localhost
- **Tecnologias:** PHP 8.1, Apache, Composer
- **Extensões:** PDO, MySQL, GD, ZIP, MBString

### 🗄️ Banco de Dados (MySQL)
- **Porta:** 3306
- **Banco:** smartsecurity
- **Usuário:** root
- **Senha:** (vazia)

### 🔧 phpMyAdmin
- **Porta:** 8080
- **URL:** http://localhost:80
- **Acesso:** root (sem senha)

## 🛠️ Comandos Úteis

### Gerenciamento dos Containers
```bash
# Subir containers
docker-compose up -d

# Parar containers
docker-compose down

# Reiniciar containers
docker-compose restart

# Ver logs
docker-compose logs -f

# Ver status
docker-compose ps
```

### Acesso aos Containers
```bash
# Acessar container web
docker-compose exec web bash

# Acessar MySQL
docker-compose exec banco mysql -u root smartsecurity

# Executar Composer
docker-compose exec web composer install
```

### Backup e Restore
```bash
# Backup do banco
docker-compose exec banco mysqldump -u root smartsecurity > backup.sql

# Restore do banco
docker-compose exec -T banco mysql -u root smartsecurity < backup.sql
```

## 🔧 Configurações

### Variáveis de Ambiente (.env)
```env
DB_HOST=banco
DB_PORT=3306
DB_NAME=smartsecurity
DB_USER=root
DB_PASS=
```

### Volumes Persistentes
- `banco_data`: Dados do MySQL
- `./public/uploads`: Arquivos enviados pelos usuários

### Rede
- Rede interna: `smartsecurity-network`
- Comunicação entre containers via nomes de serviço

## 🐛 Solução de Problemas

### Container não inicia
```bash
# Verificar logs
docker-compose logs web
docker-compose logs banco

# Reconstruir imagens
docker-compose build --no-cache
docker-compose up -d
```

### Erro de permissão
```bash
# Corrigir permissões
docker-compose exec web chown -R www-data:www-data /var/www/html
docker-compose exec web chmod -R 777 /var/www/html/public/uploads
```

### Banco não conecta
```bash
# Verificar se MySQL está rodando
docker-compose exec banco mysql -u root -e "SELECT 1"

# Recriar banco
docker-compose down -v
docker-compose up -d
```

### Limpar tudo e recomeçar
```bash
# Parar e remover tudo
docker-compose down -v --rmi all

# Subir novamente
docker-compose up -d
```

## 📊 Monitoramento

### Logs em Tempo Real
```bash
# Todos os serviços
docker-compose logs -f

# Apenas web
docker-compose logs -f web

# Apenas banco
docker-compose logs -f banco
```

### Uso de Recursos
```bash
# Ver uso de CPU/Memória
docker stats

# Ver espaço em disco
docker system df
```

## 🔒 Segurança

### Configurações Aplicadas
- Headers de segurança no Apache
- Diretório uploads protegido
- Configurações PHP seguras
- Rede isolada para containers

### Para Produção
```bash
# Usar arquivo de ambiente de produção
cp .env.production .env

# Desabilitar debug
APP_DEBUG=false

# Usar HTTPS
APP_URL=https://seu-dominio.com
```

## 🚀 Deploy em Produção

### Docker Swarm
```bash
# Inicializar swarm
docker swarm init

# Deploy
docker stack deploy -c docker-compose.yml smartsecurity
```

### Com Proxy Reverso (Nginx)
```yaml
# Adicionar ao docker-compose.yml
nginx:
  image: nginx:alpine
  ports:
    - "443:443"
  volumes:
    - ./nginx.conf:/etc/nginx/nginx.conf
    - ./ssl:/etc/ssl
```

---

**🎉 Seu SmartSecurity está rodando em containers Docker!**

*Para dúvidas, consulte os logs ou a documentação do Docker.*

