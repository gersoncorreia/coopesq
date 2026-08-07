# Guia Passo a Passo: Deploy da COOPESQ em Subdomínio na HostGator (cPanel)

Este guia descreve o procedimento completo para realizar o deploy do portal **COOPESQ** no subdomínio **`coopesq.soulsync.ia.br`** em uma conta de hospedagem compartilhada HostGator com cPanel.

---

## 🌐 Dados de Configuração do Subdomínio
- **Subdomínio**: `coopesq.soulsync.ia.br`
- **URL de Produção**: `https://coopesq.soulsync.ia.br`
- **Diretório do Subdomínio (Document Root)**: `/home/SEU_USUARIO/coopesq.soulsync.ia.br/` *(ou `/home/SEU_USUARIO/public_html/coopesq/` dependendo da criação no cPanel)*
- **Diretório do Core (Laravel privado)**: `/home/SEU_USUARIO/coopesq_app/`

---

## 📋 Pré-requisitos na HostGator
1. **Versão do PHP**: PHP **8.2** ou **8.3** ativado para o subdomínio `coopesq.soulsync.ia.br` no cPanel (*MultiPHP Manager*).
2. **Extensões PHP Ativas**: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `curl`, `fileinfo`, `zip`, `gd`.
3. **SSL/HTTPS**: Certificado SSL grátis (Let's Encrypt / HostGator) ativado para `coopesq.soulsync.ia.br`.

---

## 🛠️ Passo 1: Preparação Local dos Arquivos

No seu computador local, execute os seguintes comandos no terminal do projeto:

### 1.1. Gerar os Arquivos de Produção do Frontend (Vite)
```bash
npm run build
```
> Isso gera os arquivos CSS/JS otimizados e minificados em `public/build/`.

### 1.2. Criar o Arquivo `.env` de Produção
Crie um arquivo `.env` ajustado para o subdomínio `coopesq.soulsync.ia.br`:

```env
APP_NAME="COOPESQ"
APP_ENV=production
APP_KEY=base64:SUA_CHAVE_GERADA_LOCALMENTE
APP_DEBUG=false
APP_URL=https://coopesq.soulsync.ia.br

LOG_CHANNEL=daily
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=seuusuario_coopesq
DB_USERNAME=seuusuario_dbuser
DB_PASSWORD=sua_senha_segura_aqui

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=public
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

---

## 🗄️ Passo 2: Banco de Dados MySQL no cPanel

1. Acesse o **cPanel** da HostGator.
2. Vá em **Assistente de Banco de Dados MySQL®**.
3. Crie um novo banco de dados (ex: `seuusuario_coopesq`).
4. Crie um novo usuário MySQL (ex: `seuusuario_dbuser`) e defina uma senha forte.
5. Vincule o Usuário ao Banco marcando **"TODOS OS PRIVILÉGIOS"**.
6. Preencha os campos `DB_DATABASE`, `DB_USERNAME` e `DB_PASSWORD` no `.env`.

---

## 📁 Passo 3: Organização dos Arquivos no Servidor

Divida os arquivos em duas áreas para garantir máxima segurança:

1. **Pasta do Core (Laravel Privado)**:
   - Crie a pasta `/home/SEU_USUARIO/coopesq_app/` na raiz da sua conta cPanel (fora do diretório web).
   - Envie **todos os arquivos do projeto** para a pasta `coopesq_app` (**exceto** `node_modules` e `.git`).

2. **Pasta do Subdomínio (Document Root Público)**:
   - Abra a pasta do subdomínio: `/home/SEU_USUARIO/coopesq.soulsync.ia.br/`.
   - Copie todo o conteúdo da pasta `coopesq_app/public/*` para dentro de `/home/SEU_USUARIO/coopesq.soulsync.ia.br/`.

---

## 🔗 Passo 4: Ajuste do `index.php` do Subdomínio

Edite o arquivo `/home/SEU_USUARIO/coopesq.soulsync.ia.br/index.php` no Gerenciador de Arquivos do cPanel e aponte os caminhos para a pasta `coopesq_app`:

```php
<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Verificar se o sistema está em manutenção
if (file_exists($maintenance = __DIR__.'/../coopesq_app/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Carregar o Autoloader do Composer
require __DIR__.'/../coopesq_app/vendor/autoload.php';

// Inicializar a aplicação Laravel
(require_once __DIR__.'/../coopesq_app/bootstrap/app.php')
    ->handleRequest(Request::capture());
```

---

## ⚙️ Passo 5: Arquivo `.htaccess` Otimizado para o Subdomínio

Crie ou edite o arquivo `.htaccess` localizado dentro de `/home/SEU_USUARIO/coopesq.soulsync.ia.br/.htaccess`:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # 1. Forçar HTTPS no Subdomínio coopesq.soulsync.ia.br
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://coopesq.soulsync.ia.br/$1 [R=301,L]

    # 2. Passar o Header de Autorização Bearer Token (Essencial para a API do Admin)
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # 3. Remover barras no final de URLs
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # 4. Redirecionar todas as requisições SPA / API para o index.php
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

# Impedir listagem de diretórios
Options -Indexes
```

---

## 🔑 Passo 6: Executar Migrações, Seeders e Link Simbólico

### Opção A: Via Terminal SSH (Recomendado)
Acesse a pasta `coopesq_app` via SSH:
```bash
cd ~/coopesq_app

# Executar as migrações e popular o banco com as 15 configurações whitelabel
php artisan migrate --force
php artisan db:seed --force

# Otimizar caches de produção
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Criar o Link Simbólico de imagens do storage para a pasta do subdomínio
ln -s ~/coopesq_app/storage/app/public ~/coopesq.soulsync.ia.br/storage
```

### Opção B: Via Script PHP (Caso não tenha SSH)
Se não tiver acesso ao SSH:
1. Crie um arquivo `link.php` em `/home/SEU_USUARIO/coopesq.soulsync.ia.br/link.php`:
   ```php
   <?php
   symlink('/home/SEU_USUARIO/coopesq_app/storage/app/public', '/home/SEU_USUARIO/coopesq.soulsync.ia.br/storage');
   echo "Link simbólico criado com sucesso!";
   ```
2. Acesse `https://coopesq.soulsync.ia.br/link.php` no navegador.
3. Exclua o arquivo `link.php` logo após a execução.

---

## 🔒 Passo 7: Permissões de Pastas
Garanta permissão `755` ou `775` nas seguintes pastas:
- `/home/SEU_USUARIO/coopesq_app/storage/` (e todas as subpastas)
- `/home/SEU_USUARIO/coopesq_app/bootstrap/cache/`

---

## 🚀 Passo 8: Teste de Acesso

1. **Site Público**: Acesse `https://coopesq.soulsync.ia.br`
   - Verifique o carregamento das seções, imagens e animações de Scroll-Reveal.
2. **Painel Admin**: Acesse `https://coopesq.soulsync.ia.br/admin`
   - **E-mail**: `admin@coopesq.com.br`
   - **Senha**: `password`
   - Teste a alteração e salvamento de configurações no formulário do Dashboard.

---

## ⚡ Solução de Problemas em Subdomínio HostGator

| Erro | Causa Provável | Solução |
|---|---|---|
| **Erro 500 ao acessar API/Login** | Falta do Header Authorization no `.htaccess` | Certifique-se de que o trecho `RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]` está no `.htaccess`. |
| **Erro 404 ao recarregar a página** | Módulo `mod_rewrite` inativo ou `.htaccess` fora do subdomínio | Garanta que o `.htaccess` esteja dentro de `/home/SEU_USUARIO/coopesq.soulsync.ia.br/`. |
| **Formulário de Configurações em Branco** | Cache antigo ou banco não populado | Execute `php artisan db:seed --force` e limpe o cache com `php artisan cache:clear`. |
