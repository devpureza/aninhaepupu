# 🚀 Deploy Laravel Cloud - Site Casamento Ana & Mateus

## Pré-requisitos

- Conta no [Laravel Cloud](https://cloud.laravel.com)
- Repositório GitHub: `devpureza/aninhaepupu`
- Credenciais Mercado Pago (Access Token e Public Key)

---

## Passo a Passo

### 1️⃣ Criar Novo Projeto no Laravel Cloud

1. Acesse https://cloud.laravel.com
2. Clique em **"New Project"**
3. Conecte sua conta GitHub
4. Selecione o repositório: **devpureza/aninhaepupu**
5. Branch: **main**
6. Região: Escolha a mais próxima (ex: São Paulo ou US East)

### 2️⃣ Configurar Banco de Dados MySQL 8

O Laravel Cloud permite escolher MySQL 8 (mais econômico) ou PostgreSQL. Selecione **MySQL 8.0** durante a criação do projeto.

### 3️⃣ Configurar Variáveis de Ambiente

No painel do Laravel Cloud, vá em **Environment** e configure:

```env
APP_NAME="Casamento Ana & Mateus"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seu-dominio.laravel.app

# Laravel Cloud preenche automaticamente:
DB_CONNECTION=mysql
DB_HOST=<fornecido pelo Laravel Cloud>
DB_PORT=3306
DB_DATABASE=<fornecido pelo Laravel Cloud>
DB_USERNAME=<fornecido pelo Laravel Cloud>
DB_PASSWORD=<fornecido pelo Laravel Cloud>

# Mercado Pago (IMPORTANTE!)
MERCADOPAGO_ACCESS_TOKEN=seu_token_aqui
MERCADOPAGO_PUBLIC_KEY=sua_chave_aqui
MERCADOPAGO_WEBHOOK_SECRET=seu_secret_aqui

# Configurações regionais
APP_LOCALE=pt_BR
APP_FALLBACK_LOCALE=pt_BR
APP_FAKER_LOCALE=pt_BR

# Logs
LOG_CHANNEL=stack
LOG_LEVEL=error

# Session e Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Email (usar SMTP do Gmail ou serviço da sua escolha)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="contato@casamentoanaemateus.com.br"
MAIL_FROM_NAME="Ana & Mateus"

# Dados do evento
EVENT_DATE="2026-05-16 16:30:00"
EVENT_VENUE="Alegranza Eventos"
EVENT_ADDRESS="Lt.28 - Av. Capyaba - Jardim Helvecia, Aparecida de Goiânia - GO, 74933-260"
EVENT_MAPS_URL="https://maps.app.goo.gl/3KjczRfytcjfk4LW9"
```

### 4️⃣ Deploy Inicial

1. Laravel Cloud detecta automaticamente e instala dependências
2. Executa `composer install --optimize-autoloader --no-dev`
3. Executa `npm install && npm run build`
4. Gera chave de aplicação automaticamente
5. **IMPORTANTE:** Configure o script de deploy em **Settings → Deploy Script**:

```bash
bash deploy.sh
```

Este script cria diretórios necessários, otimiza caches e executa migrations automaticamente.

### 5️⃣ Executar Migrations (Se Necessário)

Se o script de deploy não executou automaticamente, rode via **Terminal** no painel Laravel Cloud:

```bash
php artisan migrate --force
```

Se quiser dados de demonstração:
```bash
php artisan db:seed
```

### 6️⃣ Criar Usuário Admin

Via terminal:

```bash
php artisan tinker
```

Depois execute:
```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'seu-email@example.com',
    'password' => bcrypt('sua-senha-segura')
]);
```

Pressione `Ctrl+C` para sair.

### 7️⃣ Configurar Domínio Personalizado (Opcional)

1. No painel, vá em **Domains**
2. Adicione seu domínio: `casamentoanaemateus.com.br`
3. Configure DNS apontando para os nameservers do Laravel Cloud
4. Laravel Cloud configura SSL automaticamente

### 8️⃣ Configurar Webhook do Mercado Pago

Após deploy, configure no painel do Mercado Pago:

**URL do Webhook:**
```
https://seu-dominio.laravel.app/webhooks/payments/mercadopago
```

**Eventos:**
- ✅ Payments

### 9️⃣ Testar o Site

1. Acesse: `https://seu-dominio.laravel.app`
2. Painel admin: `https://seu-dominio.laravel.app/admin`
3. Teste o fluxo de presentes e pagamento

---

## ⚙️ Comandos Úteis

### Limpar cache
```bash
php artisan optimize:clear
```

### Ver logs
```bash
php artisan pail
```

### Executar queue worker
O Laravel Cloud configura automaticamente workers para filas.

### Verificar status da aplicação
```bash
php artisan about
```

---

## 🔒 Segurança

- ✅ SSL configurado automaticamente
- ✅ Firewall gerenciado
- ✅ Backups automáticos do banco
- ✅ Monitoramento de uptime
- ✅ Zero-downtime deployments

---

## 📊 Monitoramento

Laravel Cloud fornece:
- Logs em tempo real
- Métricas de performance
- Alertas de erro
- Uso de recursos

Acesse via painel: **Monitoring**

---

## 🔄 Deploy de Atualizações

### Método Automático
Basta fazer push no GitHub:
```bash
git add .
git commit -m "Sua mensagem"
git push
```

Laravel Cloud detecta e faz deploy automaticamente!

### Método Manual
No painel Laravel Cloud:
1. Vá em **Deployments**
2. Clique em **Deploy Now**

---

## 🆘 Troubleshooting

### Erro de migration
```bash
php artisan migrate:fresh --force
```

### Permissões de storage
Configurado automaticamente no Laravel Cloud.

### Erro 500
Verifique logs:
```bash
tail -f storage/logs/laravel.log
```

### Webhook não funciona
1. Verifique URL no Mercado Pago
2. Teste manualmente: `POST /webhooks/payments/mercadopago`
3. Veja logs do webhook na tabela `webhook_logs`

---

## 📞 Suporte

- Documentação Laravel Cloud: https://docs.cloud.laravel.com
- Suporte Laravel: https://laravel.com/support

**Projeto pronto para produção! 🎉**
