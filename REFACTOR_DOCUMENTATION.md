# SmartSecurity - Sistema Refatorado com Laravel/Vue.js

## 📋 Visão Geral

Este documento descreve a refatoração completa do sistema SmartSecurity, migrando de PHP puro para uma arquitetura moderna usando **Laravel 11** com **Vue.js 3** e **Inertia.js**.

## 🚀 Tecnologias Implementadas

### Backend
- **Laravel 11** - Framework PHP moderno
- **SQLite** - Banco de dados (configurado para desenvolvimento)
- **Inertia.js** - Bridge entre Laravel e Vue.js
- **Eloquent ORM** - Mapeamento objeto-relacional

### Frontend
- **Vue.js 3** - Framework JavaScript reativo
- **Composition API** - API moderna do Vue.js
- **Tailwind CSS** - Framework CSS utilitário
- **Heroicons** - Biblioteca de ícones
- **Vite** - Build tool moderno

### Ferramentas de Desenvolvimento
- **Composer** - Gerenciador de dependências PHP
- **NPM** - Gerenciador de dependências JavaScript
- **Artisan** - CLI do Laravel

## 📁 Estrutura do Projeto

```
SmartSecurity-Laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php
│   │   │   └── OccurrenceController.php
│   │   └── Middleware/
│   │       └── HandleInertiaRequests.php
│   └── Models/
│       ├── User.php
│       ├── Profile.php
│       └── Occurrence.php
├── database/
│   ├── migrations/
│   │   ├── create_profiles_table.php
│   │   ├── create_users_table.php
│   │   ├── create_occurrences_table.php
│   │   └── [outras migrations]
│   └── seeders/
│       ├── ProfileSeeder.php
│       └── UserSeeder.php
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   ├── app.js
│   │   ├── Components/
│   │   │   ├── NavLink.vue
│   │   │   ├── Dropdown.vue
│   │   │   └── Pagination.vue
│   │   ├── Layouts/
│   │   │   └── AppLayout.vue
│   │   └── Pages/
│   │       ├── Home.vue
│   │       └── Occurrences/
│   │           ├── Index.vue
│   │           └── Create.vue
│   └── views/
│       └── app.blade.php
├── routes/
│   └── web.php
├── public/
├── vendor/
├── node_modules/
├── .env
├── composer.json
├── package.json
├── tailwind.config.js
├── vite.config.js
└── postcss.config.js
```

## 🗄️ Estrutura do Banco de Dados

### Tabelas Principais

#### profiles
- `id` - Chave primária
- `name` - Nome do perfil (Administrador, Usuário, Moderador)
- `description` - Descrição do perfil
- `created_at`, `updated_at` - Timestamps

#### users
- `id` - Chave primária
- `first_name` - Primeiro nome
- `last_name` - Sobrenome
- `email` - Email único
- `password` - Senha criptografada
- `profile_id` - Chave estrangeira para profiles
- `email_verified_at` - Timestamp de verificação
- `remember_token` - Token de "lembrar-me"
- `created_at`, `updated_at` - Timestamps

#### occurrences
- `id` - Chave primária
- `user_id` - Chave estrangeira para users
- `type` - Tipo da ocorrência (Assalto, Furto, etc.)
- `title` - Título da ocorrência
- `description` - Descrição detalhada
- `occurred_at` - Data/hora da ocorrência
- `location` - Localização
- `status` - Status (pending, verified, rejected)
- `latitude`, `longitude` - Coordenadas geográficas
- `images` - JSON com caminhos das imagens
- `views_count` - Contador de visualizações
- `rating` - Avaliação média
- `rating_count` - Número de avaliações
- `created_at`, `updated_at` - Timestamps

### Relacionamentos
- **User** belongsTo **Profile**
- **User** hasMany **Occurrences**
- **Occurrence** belongsTo **User**

## 🎨 Interface do Usuário

### Layout Principal (AppLayout.vue)
- **Navegação responsiva** com menu mobile
- **Sistema de notificações** flash
- **Footer informativo**
- **Design moderno** com Tailwind CSS

### Páginas Implementadas

#### Home (Home.vue)
- **Hero section** com gradiente atrativo
- **Estatísticas em tempo real**
- **Seção "Como Funciona"**
- **Ocorrências recentes**
- **Call-to-actions** para engajamento

#### Listagem de Ocorrências (Occurrences/Index.vue)
- **Sistema de filtros** avançado (tipo, status, localização, busca)
- **Cards responsivos** para cada ocorrência
- **Paginação** integrada
- **Indicadores visuais** de status e tipo
- **Contador de visualizações**

#### Criação de Ocorrências (Occurrences/Create.vue)
- **Formulário completo** com validação
- **Upload múltiplo** de imagens
- **Geolocalização automática**
- **Preview de imagens**
- **Validação em tempo real**

### Componentes Reutilizáveis
- **NavLink** - Links de navegação com estado ativo
- **ResponsiveNavLink** - Links para menu mobile
- **Dropdown** - Menu dropdown com animações
- **DropdownLink** - Items do dropdown
- **Pagination** - Paginação estilizada

## 🔧 Funcionalidades Implementadas

### Sistema de Ocorrências
- ✅ **Listagem** com filtros e paginação
- ✅ **Criação** com upload de imagens
- ✅ **Visualização** detalhada
- ✅ **Sistema de status** (pendente, verificado, rejeitado)
- ✅ **Geolocalização** opcional
- ✅ **Contador de visualizações**

### Sistema de Usuários
- ✅ **Modelo de usuário** modernizado
- ✅ **Sistema de perfis** (Administrador, Usuário, Moderador)
- ✅ **Relacionamentos** entre modelos

### Interface
- ✅ **Design responsivo** mobile-first
- ✅ **Componentes reutilizáveis**
- ✅ **Sistema de notificações**
- ✅ **Navegação intuitiva**

## 🎯 Melhorias Implementadas

### Arquitetura
- **Separação de responsabilidades** com MVC
- **Eloquent ORM** para queries otimizadas
- **Middleware** para funcionalidades transversais
- **Migrations** para versionamento do banco

### Performance
- **Lazy loading** de relacionamentos
- **Paginação** eficiente
- **Índices** no banco de dados
- **Build otimizado** com Vite

### Segurança
- **Validação** de dados no backend
- **Proteção CSRF** automática
- **Sanitização** de inputs
- **Prepared statements** via Eloquent

### Experiência do Usuário
- **Interface moderna** e intuitiva
- **Feedback visual** imediato
- **Animações suaves**
- **Responsividade** completa

## 🚧 Próximas Implementações

### Autenticação e Autorização
- [ ] Sistema de login/registro
- [ ] Middleware de autenticação
- [ ] Controle de permissões por perfil
- [ ] Recuperação de senha

### Funcionalidades Avançadas
- [ ] Sistema de comentários
- [ ] Avaliações de ocorrências
- [ ] Notificações em tempo real
- [ ] Dashboard administrativo
- [ ] Relatórios e estatísticas avançadas

### Testes e CI/CD
- [ ] Testes unitários
- [ ] Testes de integração
- [ ] Pipeline de CI/CD
- [ ] Deploy automatizado

## 📊 Comparação: Antes vs Depois

### Sistema Original
- PHP procedural sem organização
- HTML/CSS básico não responsivo
- Estrutura de arquivos confusa
- Sem validação adequada
- Design desatualizado
- Vulnerabilidades de segurança

### Sistema Refatorado
- **Laravel 11** com arquitetura MVC
- **Vue.js 3** com Composition API
- **Inertia.js** para SPA moderna
- **Tailwind CSS** para design responsivo
- **Validação robusta** no backend
- **Segurança aprimorada**
- **Performance otimizada**
- **Código limpo e documentado**

## 🛠️ Como Executar

### Pré-requisitos
- PHP 8.1+
- Composer
- Node.js 18+
- NPM

### Instalação
```bash
# Clonar o repositório
git clone [repository-url]
cd SmartSecurity-Laravel

# Instalar dependências PHP
composer install

# Instalar dependências JavaScript
npm install

# Configurar ambiente
cp .env.example .env
php artisan key:generate

# Configurar banco de dados
touch database/database.sqlite
php artisan migrate
php artisan db:seed

# Build dos assets
npm run build

# Iniciar servidor
php artisan serve
```

### Desenvolvimento
```bash
# Modo de desenvolvimento com hot reload
npm run dev

# Em outro terminal
php artisan serve
```

## 📝 Conclusão

A refatoração do SmartSecurity representa uma modernização completa do sistema, implementando as melhores práticas atuais de desenvolvimento web. A nova arquitetura oferece:

- **Escalabilidade** para crescimento futuro
- **Manutenibilidade** com código organizado
- **Performance** otimizada
- **Segurança** robusta
- **Experiência do usuário** superior

O sistema está preparado para receber novas funcionalidades e evoluir conforme as necessidades da comunidade de Ceilândia e região.

---

**Desenvolvido com ❤️ para a comunidade de Ceilândia**

*Sistema modernizado em 2025 com Laravel, Vue.js e Inertia.js*
