# Guia Passo a Passo: Deploy via Git/GitHub no Subdomínio HostGator (cPanel)

Este guia descreve o procedimento passo a passo para clonar o projeto **COOPESQ** direto do GitHub (`https://github.com/gersoncorreia/coopesq.git`) para o subdomínio **`coopesq.soulsync.ia.br`** no servidor da HostGator via Terminal SSH ou pelo *Git™ Version Control* do cPanel.

---

## 🌐 Dados da Aplicação
- **Repositório GitHub**: `https://github.com/gersoncorreia/coopesq.git`
- **Subdomínio**: `coopesq.soulsync.ia.br`
- **URL Final**: `https://coopesq.soulsync.ia.br`
- **Diretório do Código (Laravel Core)**: `/home/SEU_USUARIO/coopesq_app/`
- **Diretório do Subdomínio (Document Root Público)**: `/home/SEU_USUARIO/coopesq.soulsync.ia.br/` (ou diretamente apontado para `coopesq_app/public`)

---

## 📋 Pré-requisitos na HostGator (cPanel)

1. **Ativar o PHP 8.2 ou 8.3**:
   - Acesse o cPanel > **Gerenciador MultiPHP (MultiPHP Manager)**.
   - Selecione o subdomínio `coopesq.soulsync.ia.br` e defina a versão do PHP para **PHP 8.2** ou **PHP 8.3**.
2. **Ativar o SSL (HTTPS)**:
   - Vá em **SSL/TLS Status** ou **AutoSSL** no cPanel e execute a verificação para garantir HTTPS grátis no subdomínio `coopesq.soulsync.ia.br`.

---

## 🚀 Passo 1: Clonar o Repositório do GitHub no Servidor

### Método A: Via Terminal SSH (Recomendado & Mais Rápido)

1. Conecte-se à sua conta HostGator via SSH:
   ```bash
   ssh usuario@soulsync.ia.br
   ```
2. Vá para a raiz da sua conta (home) e clone o repositório em uma pasta privada chamada `coopesq_app`:
   ```bash
   cd ~
   git clone https://github.com/gersoncorreia/coopesq.git coopesq_app
   ```

---

### Método B: Via Interface do cPanel (Git™ Version Control)

1. Acesse o **cPanel** da HostGator.
2. Procure pela ferramenta **Controle de Versão Git™ (Git™ Version Control)**.
3. Clique em **Criar (Create)**.
4. Preencha os campos:
   - **Clone URL**: `https://github.com/gersoncorreia/coopesq.git`
   - **Repository Path**: `coopesq_app`
   - **Repository Name**: `coopesq`
5. Clique em **Criar (Create)**.
> **Vantagem**: Sempre que fizer novos commits no GitHub, basta clicar no botão **"Pull from Remote"** dentro dessa ferramenta no cPanel para atualizar o código em 1 segundo!

---

## 📦 Passo 2: Instalar Dependências e Configurar o `.env`

Acesse a pasta do projeto clonado no servidor (via SSH):

```bash
cd ~/coopesq_app
```

### 2.1. Configuração Global do Composer na HostGator (Resolver `command not found`)

> ⚠️ Na HostGator compartilhada (jailshell), o comando `composer` não vem ativado globalmente por padrão. Siga os 4 passos abaixo **uma única vez** para instalar o Composer de forma **GLOBAL** na sua conta de usuário:

```bash
# 1. Criar a pasta bin no diretório raiz do seu usuário
mkdir -p ~/bin

# 2. Baixar o arquivo binário do Composer para a pasta ~/bin/composer
cd ~
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
mv composer.phar ~/bin/composer
chmod +x ~/bin/composer

# 3. Adicionar o executável e o atalho no PATH e no arquivo de perfil (.bashrc e .bash_profile)
echo 'export PATH="$HOME/bin:$PATH"' >> ~/.bashrc
echo 'export PATH="$HOME/bin:$PATH"' >> ~/.bash_profile
echo 'alias composer="php ~/bin/composer"' >> ~/.bashrc
echo 'alias composer="php ~/bin/composer"' >> ~/.bash_profile

# 4. Recarregar os arquivos de configuração da sua sessão SSH
source ~/.bashrc
source ~/.bash_profile
```

Após fazer os 4 passos acima, teste digitando em qualquer pasta:
```bash
composer -V
```
Você verá a saída: `Composer version 2.x.x ...` e o comando `composer` passará a funcionar **globalmente** em qualquer pasta da sua conta!

#### Executar a Instalação no Projeto:
```bash
cd ~/coopesq_app
composer install --no-dev --optimize-autoloader
```

### 2.2. Criar e Configurar o Arquivo `.env` de Produção
Copie o arquivo `.env.example` para `.env`:
```bash
cp .env.example .env
```

Edite o `.env` (`nano .env` ou via Gerenciador de Arquivos do cPanel):

```env
APP_NAME="COOPESQ"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://coopesq.soulsync.ia.br

LOG_CHANNEL=daily
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

### 2.3. Gerar a Chave da Aplicação Laravel
```bash
php artisan key:generate
```

---

## 🗄️ Passo 3: Criar o Banco de Dados MySQL no cPanel

1. No cPanel, vá em **Assistente de Banco de Dados MySQL®**.
2. Crie o banco de dados (ex: `seuusuario_coopesq`).
3. Crie o usuário (ex: `seuusuario_dbuser`) com uma senha forte.
4. Marque a caixa **"TODOS OS PRIVILÉGIOS"** e confirme.
5. Atualize as credenciais no arquivo `.env`.

---

## ⚙️ Passo 4: Executar Migrações, Populador de Dados (Seeders) e Link de Storage

Dentro da pasta `~/coopesq_app`, execute os comandos abaixo:

```bash
# 1. Executar migrações do banco de dados
php artisan migrate --force

# 2. Popular o banco com os seeders modulares atualizados (20 configurações, banners, 12 parceiros em SVG, catálogo e blog)
php artisan db:seed --force

# 3. Criar link simbólico do storage (Essencial para exibir logotipos, banners e imagens em /storage/uploads/)
php artisan storage:link

# 4. Limpar e otimizar caches de configuração, rotas e views do Laravel
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🔗 Passo 5: Vincular o Subdomínio ao Projeto Clonado

Existem duas maneiras simples de conectar o subdomínio `coopesq.soulsync.ia.br` ao código clonado:

### Opção 1: Alterar o Document Root no cPanel (A Forma Mais Limpa)
1. No cPanel, acesse **Domínios (Domains)** ou **Subdomínios (Subdomains)**.
2. Na linha do subdomínio `coopesq.soulsync.ia.br`, clique em **Editar / Gerenciar**.
3. Altere o campo **Document Root** de `/public_html/coopesq` para:
   ```
   /home/SEU_USUARIO/coopesq_app/public
   ```
4. Salve. Pronto! O subdomínio apontará diretamente para a pasta pública do projeto clonado sem precisar copiar arquivos ou criar links adicionais.

---

### Opção 2: Copiar a Pasta Pública e Criar Link Simbólico (Se o cPanel não permitir alterar a raiz)
Caso o seu plano cPanel não permita alterar a raiz do subdomínio:
1. Abra a pasta do subdomínio: `~/coopesq.soulsync.ia.br/` (ou `~/public_html/coopesq/`).
2. Copie os arquivos da pasta `~/coopesq_app/public/*` para dentro da pasta do subdomínio.
3. Edite o `index.php` do subdomínio apontando o autoloader para `../coopesq_app/vendor/autoload.php`.
4. Crie o link simbólico do armazenamento:
   ```bash
   ln -s ~/coopesq_app/storage/app/public ~/coopesq.soulsync.ia.br/storage
   ```

---

## 🔒 Passo 6: Configurar o Arquivo `.htaccess` para o Subdomínio

Certifique-se de que o arquivo `.htaccess` na pasta pública do subdomínio possua as seguintes regras essenciais:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # 1. Forçar HTTPS no Subdomínio coopesq.soulsync.ia.br
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://coopesq.soulsync.ia.br/$1 [R=301,L]

    # 2. Preservar o Header de Autorização Bearer Token (Essencial para o login e APIs do Admin)
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # 3. Remover barras no final de URLs
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # 4. Redirecionar requisições SPA (Vue / Inertia) e API para o index.php
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

# Impedir listagem de diretórios
Options -Indexes
```

---

## 🔑 Passo 7: Permissões de Leitura e Escrita

No terminal SSH, aplique permissão de escrita nas pastas de cache e armazenamento:

```bash
chmod -R 775 ~/coopesq_app/storage
chmod -R 775 ~/coopesq_app/bootstrap/cache
```

---

## 🔄 Como Atualizar o Site no Servidor de Produção (Deploy das Novas Versões)
 
Sempre que fizer alterações no projeto e enviar para o GitHub (`git push origin main`), execute os passos abaixo no servidor de produção para aplicar as novidades imediatamente:
 
### Opção A: Via Terminal SSH (Recomendado)
```bash
cd ~/coopesq_app

# 1. Puxar as últimas alterações do GitHub (inclui assets compilados, novos componentes e seeders)
git pull origin main

# 2. Aplicar eventuais migrações de banco
php artisan migrate --force

# 3. Atualizar dados cadastrais institucionais, banners e parceiros atualizados
php artisan db:seed --force

# 4. Garantir que o link de storage continue ativo
php artisan storage:link

# 5. Limpar e reaquecer todos os caches do Laravel
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
 
### Opção B: Via cPanel (Git™ Version Control)
1. Acesse **cPanel > Git™ Version Control**.
2. Clique em **Gerenciar (Manage)** no repositório `coopesq`.
3. Na aba **Pull or Deploy**, clique no botão azul **"Pull from Remote"**.
4. No terminal do cPanel, rode:
   ```bash
   cd ~/coopesq_app && php artisan db:seed --force && php artisan optimize:clear && php artisan config:cache && php artisan route:cache
   ```

---

## 🚀 Passo 8: Verificação Final

1. **Portal Público**: Acesse `https://coopesq.soulsync.ia.br`
   - Teste as imagens, catálogo de produtos e animações Scroll-Reveal.
2. **Painel Administrativo**: Acesse `https://coopesq.soulsync.ia.br/admin`
   - Os campos de e-mail e senha iniciam completamente vazios por segurança.
   - **E-mail de Acesso**: `admin@coopesq.com.br`
   - **Senha Padrão**: `password` (Recomenda-se alterar nas configurações do painel)
   - Teste o login para confirmar o pleno funcionamento do token Sanctum e navegue pelo painel responsivo!

---

## ⚡ Solução de Erros Frequentes na HostGator

| Erro | Causa Provável | Solução Passo a Passo |
|---|---|---|
| **ERRO 403 ACESSO NEGADO (Forbidden)** | Document Root apontando para pasta errada OU falta do `DirectoryIndex` OU permissão `777` em pastas | **1.** No cPanel > *Domínios*, confirme se a raiz de `coopesq.soulsync.ia.br` aponta para `/home/SEU_USUARIO/coopesq_app/public`.<br>**2.** No SSH, aplique permissões válidas do suPHP: `chmod 755 ~/coopesq_app/public` e `chmod 644 ~/coopesq_app/public/index.php`. |
| **Erro 500 ao acessar API/Login** | Falta do Header Authorization ou permissão de escrita em `storage/` | **1.** Verifique o `.htaccess`.<br>**2.** Aplique: `chmod -R 775 ~/coopesq_app/storage`. |
| **Erro 404 ao recarregar a página** | `.htaccess` ausente na pasta do subdomínio | Garanta que o `.htaccess` esteja dentro de `coopesq_app/public/` ou no diretório do subdomínio. |

