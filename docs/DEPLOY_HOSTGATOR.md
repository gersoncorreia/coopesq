# Guia Passo a Passo: Deploy da COOPESQ na Hospedagem Compartilhada (HostGator / cPanel)

Este guia prático descreve o procedimento completo para realizar o deploy do portal **COOPESQ** (Laravel 12 + Vue 3 Whitelabel) em uma conta de hospedagem compartilhada HostGator com cPanel.

---

## 📋 Pré-requisitos na HostGator
1. **Versão do PHP**: PHP **8.2** ou **8.3** ativado no cPanel (*MultiPHP Manager*).
2. **Extensões PHP Ativas**: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `curl`, `fileinfo`, `zip`, `gd`.
3. **Acesso SSH** (Opcional, mas recomendado) ou **Gerenciador de Arquivos do cPanel**.

---

## 🛠️ Passo 1: Preparação Local dos Arquivos

No seu computador local, execute os seguintes comandos no terminal do projeto:

### 1.1. Gerar os Arquivos de Produção do Frontend (Vite)
```bash
npm run build
```
> Isso irá gerar os arquivos otimizados e minificados em `public/build/`.

### 1.2. Gerar o Arquivo `.env` de Produção
Crie um arquivo `.env` para produção (baseado no `.env.example`):
```env
APP_NAME="COOPESQ"
APP_ENV=production
APP_KEY=base64:COPIE_A_SUA_CHAVE_GERADA_LOCALMENTE
APP_DEBUG=false
APP_URL=https://seudominio.com.br

LOG_CHANNEL=daily
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco_cpanel
DB_USERNAME=usuario_do_banco_cpanel
DB_PASSWORD=senha_do_banco_cpanel

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=public
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

---

## 🗄️ Passo 2: Configuração do Banco de Dados MySQL na HostGator

1. Acesse o **cPanel** da HostGator.
2. Vá em **Bancos de Dados MySQL®** ou **Assistente de Banco de Dados MySQL**.
3. Crie um novo banco de dados (ex: `seuusuario_coopesq`).
4. Crie um novo usuário MySQL (ex: `seuusuario_dbuser`) e defina uma senha forte.
5. Adicione o Usuário ao Banco de Dados marcando a opção **"TODOS OS PRIVILÉGIOS"**.
6. Anote o Nome do Banco, Usuário e Senha e preencha no `.env`.

---

## 📁 Passo 3: Estrutura de Arquivos Segura na Hospedagem

Na hospedagem compartilhada, para maior segurança, dividimos o projeto em duas partes:
1. **Arquivos do Core (Laravel)**: Ficam fora do diretório público (ex: `/home/seuusuario/coopesq_app/`).
2. **Arquivos Públicos (Vite, CSS, JS, index.php)**: Ficam dentro de `/public_html/`.

### 3.1. Enviar os Arquivos via FTP / SSH / Gerenciador do cPanel
- Crie uma pasta chamada `coopesq_app` na raiz do seu servidor (no mesmo nível de `public_html`).
- Envie **todos os arquivos do projeto** para a pasta `coopesq_app` **EXCETO** a pasta `node_modules` e a pasta `.git`.
- Mova o conteúdo de `coopesq_app/public/*` para dentro de `/public_html/`.

---

## 🔗 Passo 4: Ajuste das Rotas de Inicialização (`index.php`)

Abra o arquivo `/public_html/index.php` para editar no cPanel e altere as linhas de inclusão do bootstrap para apontar para a pasta `coopesq_app`:

```php
<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is under maintenance...
if (file_exists($maintenance = __DIR__.'/../coopesq_app/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Auto Loader...
require __DIR__.'/../coopesq_app/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../coopesq_app/bootstrap/app.php')
    ->handleRequest(Request::capture());
```

---

## 🔑 Passo 5: Migrações, Seeders e Links de Armazenamento

### Opção A: Via Terminal SSH (Recomendado)
Acesse a pasta `coopesq_app` via SSH e rode:
```bash
cd ~/coopesq_app

# Executar as migrações e popular as configurações iniciais no banco
php artisan migrate --force
php artisan db:seed --force

# Limpar e otimizar caches de produção
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Criar o Link Simbólico da pasta storage para o public_html
ln -s ~/coopesq_app/storage/app/public ~/public_html/storage
```

### Opção B: Caso Não Tenha Acesso ao Terminal SSH
Se sua conta HostGator não possuir acesso SSH:
1. **Banco de Dados**: Exporte o banco de dados SQLite local ou utilize o phpMyAdmin para importar o script `.sql`.
2. **Link Simbólico do Storage**: Crie um arquivo `link.php` dentro de `public_html/` com o código:
   ```php
   <?php
   symlink('/home/SEU_USUARIO_CPANEL/coopesq_app/storage/app/public', '/home/SEU_USUARIO_CPANEL/public_html/storage');
   echo "Link simbólico criado com sucesso!";
   ```
   Acesse `https://seudominio.com.br/link.php` no navegador e depois apague o arquivo `link.php`.

---

## 🔒 Passo 6: Permissões de Pastas e Redirecionamento HTTPS (.htaccess)

### 6.1. Permissões de Leitura e Escrita
Garanta que as pastas de armazenamento tenham permissão `755` ou `775`:
- `coopesq_app/storage` (e subpastas)
- `coopesq_app/bootstrap/cache`

### 6.2. Forçar HTTPS e Segurança no `.htaccess`
Crie ou ajuste o arquivo `/public_html/.htaccess`:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Forçar HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

---

## 🚀 Passo 7: Verificação do Deploy

1. Acesse `https://seudominio.com.br` e verifique:
   - Carregamento da página inicial, estilos CSS e imagens.
   - Animações de Scroll-Reveal funcionando.
   - Navegação pelas abas de produtos e blog.
2. Acesse `https://seudominio.com.br/admin` e faça login com:
   - **E-mail**: `admin@coopesq.com.br`
   - **Senha**: `password` *(Altere a senha após o primeiro acesso no painel!)*.

---

## ⚡ Solução de Problemas Comuns na HostGator

| Erro | Causa Provável | Solução |
|---|---|---|
| **Erro 500 Internal Server Error** | Permissões incorretas ou arquivo `.env` ausente | Verifique as permissões de `storage/` e consulte os logs em `storage/logs/laravel.log`. |
| **Página em Branco no Dashboard** | Cache do navegador ou rotas API sem `index.php` | Acesse com `Ctrl+Shift+R` e confirme se o `mod_rewrite` está ativo no `.htaccess`. |
| **Imagens de Produtos não Carregam** | Link simbólico do storage ausente | Execute `php artisan storage:link` ou execute a criação do `symlink`. |
| **Erro de Versão PHP** | Servidor usando PHP 7.x por padrão | Altere para PHP 8.2+ no cPanel (*MultiPHP Manager*). |
