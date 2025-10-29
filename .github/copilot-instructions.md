# Instruções para Agentes de IA — Site de Casamento Ana & Mateus

## Visão Geral do Projeto

Sistema de gerenciamento de casamento em Laravel 12 com lista de presentes/cotas simbólicas, RSVP, checkout Mercado Pago (Pix/cartão) e painel administrativo FilamentPHP. Identidade visual personalizada (paleta terra/oliva) com design system próprio em CSS puro.

**Stack Principal:** Laravel 12 + PHP 8.4 + FilamentPHP 4 + MySQL + Vite + CSS Custom

## Arquitetura e Estrutura

### Separação de Responsabilidades

- **Site Público:** Controllers em `app/Http/Controllers/Site/` (HomeController, GiftsController, CheckoutController, RsvpController, etc.)
- **Painel Admin:** FilamentPHP em `app/Filament/Admin/` com Resources, Widgets e customizações visuais
- **Serviços de Pagamento:** `app/Services/Payments/MercadoPagoService.php` encapsula SDK Mercado Pago
- **Views Públicas:** `resources/views/` (home.blade.php, gifts.blade.php, checkout/, etc.)

### Modelos de Dados Principais

```
Guest → Rsvp (convidados e confirmações de presença)
Product (presentes/cotas simbólicas com price_cents, min/max para valor livre)
Order → OrderItem, Payment, Message (pedidos com itens, pagamento e mensagem opcional)
Payment (gateway='mercadopago', method='pix|card', status, gateway_charge_id)
WebhookLog (auditoria de webhooks recebidos)
```

**Convenção de Valores Monetários:** SEMPRE usar centavos (ex: `price_cents`, `total_cents`). Conversão para reais: `$cents / 100`. Formatação: `number_format($cents / 100, 2, ',', '.')`.

### Fluxo de Checkout Completo

1. Usuário seleciona produto em `/presentes`
2. Se `Product::allowsCustomAmount()` (min_cents/max_cents definidos), validar valor customizado
3. `CheckoutController::store()` cria Order + OrderItem + Payment (status='pending')
4. `MercadoPagoService::createPreference()` gera link de pagamento (init_point)
5. Redirect para Mercado Pago
6. Webhook POST `/webhooks/payments/mercadopago` atualiza Payment e Order status
7. Retorno para `/checkout/sucesso/{order:code}` ou `/checkout/pendente/{order:code}`

**Importante:** `Order::code` é gerado automaticamente em `boot()` com formato `ORD-XXXXXXXXXX` (único). Payment armazena `gateway_charge_id` do Mercado Pago.

## Design System & Identidade Visual

### Paleta de Cores (Tokens CSS)

```css
--am-primary: #5f6848     /* Verde Oliva (cor de marca) */
--am-primary-soft: #7e957e /* Esperança (hover, realces) */
--am-amber: #d38c4a        /* Olhinhos (acentos) */
--am-sand: #e0decd         /* Confiança (fundos alt, bordas) */
--am-background: #faf9f5   /* Calmaria (fundo principal) */
```

### Tipografia

- **Títulos/Headings:** 'Cormorant Garamond' (serif display, Google Fonts)
- **Corpo/UI:** 'Manrope' (sans-serif geométrica, Google Fonts)
- Arquivo: `public/css/filament-custom.css` centraliza fontes e tokens

### Componentes e Padrões

- **Cards:** `border-radius: 18-24px`, sombras suaves, bordas `rgba(95, 104, 72, 0.12)`
- **Botões Primários:** Fundo `--am-primary`, hover `--am-primary-soft`
- **Classes Customizadas:** Prefixo `.am-` (ex: `.am-dashboard`, `.am-dashboard__card`)

**Nunca usar Tailwind arbitrário** — o projeto usa CSS custom puro. FilamentPHP mantém suas próprias classes Tailwind, mas customizações vão em `filament-custom.css`.

## Configuração e Ambiente

### Variáveis Essenciais (.env)

```
MERCADOPAGO_ACCESS_TOKEN=     # Token de acesso MP (obrigatório para checkout)
MERCADOPAGO_PUBLIC_KEY=       # Chave pública MP
MERCADOPAGO_WEBHOOK_SECRET=   # Secret para validar webhooks (opcional)
```

### Scripts Composer Importantes

- `composer setup` — Instalação completa (composer + npm, migrations, build)
- `composer dev` — Inicia servidor + queue + logs + vite em paralelo (concurrently)
- `composer test` — Executa suite PHPUnit

**Atenção:** Sempre rodar `php artisan migrate` após criar novas migrations. Banco dev usa SQLite (`database/database.sqlite`).

## FilamentPHP — Customizações Específicas

### Painel Admin (`app/Providers/Filament/AdminPanelProvider.php`)

- **Path:** `/admin`
- **Cores:** `Color::hex('#5f6848')` para primary, `Color::hex('#646B63')` para gray
- **Logo:** `asset('monograma-am.svg')` (SVG do monograma A&M)
- **CSS Custom:** Registrado via `assets([Css::make('am-filament-theme', 'css/filament-custom.css')])`
- **Widget Principal:** `WeddingStatsWidget` exibe KPIs (total arrecadado, pedidos, ticket médio, top itens, últimas mensagens)

### Resources Filament

- **Formatação de Valores:** Usar `Tables\Columns\TextColumn::make('price_cents')->money('BRL', divideBy: 100)`
- **Ações:** Importar de `Filament\Actions\*` (EditAction, DeleteAction) e `Filament\Tables\Actions\*` para tabelas
- **Formulários:** Estruturar com `Forms\Components\Section` e `Grid` para organização visual

**Evitar:** Widgets padrão (AccountWidget, FilamentInfoWidget) — foram removidos no provider para dar lugar ao widget custom.

## Convenções e Padrões de Código

### Nomenclatura

- **Rotas públicas:** Nomes em português (`route('presentes')`, `route('checkout.store')`)
- **Controllers de Site:** Namespace `App\Http\Controllers\Site`
- **Métodos CRUD:** Seguir padrão Laravel (index, create, store, show, edit, update, destroy)

### Validação e Segurança

- **Form Requests:** Sempre criar em `app/Http/Requests/` (ex: `CheckoutRequest`)
- **Honeypot Anti-Spam:** Campos honeypot em formulários públicos (RSVP, mensagens)
- **CSRF:** Habilitado por padrão em forms Blade (`@csrf`)

### Mensagens e Tratamento de Erros

- Logar erros críticos com `Log::error('contexto', ['dados'])` antes de retornar
- Retornar `back()->withErrors(['campo' => 'mensagem'])->withInput()` em validações customizadas
- Webhooks devem retornar JSON: `response()->json(['status' => 'ok'])` ou códigos 404/500 quando apropriado

## Fluxos Específicos do Domínio

### Produtos com Valor Livre

```php
if ($product->allowsCustomAmount()) {
    // Validar que custom_amount está entre min_cents e max_cents
    $customAmount = (int) round($input['custom_amount'] * 100);
    // Aplicar validação e usar como unit_price
}
```

### RSVP e Mensagens

- **RSVP:** Guest pode confirmar presença (`attending:boolean`) e número de acompanhantes (validar contra `companions_allowed`)
- **Mensagens:** Podem estar associadas a Order ou serem independentes. Campo `is_public` controla exibição no mural. `approved:boolean` para moderação

### Webhook Mercado Pago

- Tipo esperado: `type='payment'`, `data.id` contém payment_id
- Buscar detalhes com `MercadoPagoService::findPayment($paymentId)`
- Status `approved` → Order e Payment ficam `paid`, `pending` → `pending`, outros → `failed`
- Sempre logar payload completo e gravar em `WebhookLog` para auditoria

## Comandos de Desenvolvimento

```powershell
# Setup inicial
composer setup

# Desenvolvimento local (4 processos: server, queue, logs, vite)
composer dev

# Migrations
php artisan migrate

# Seed dados de demonstração
php artisan db:seed

# Gerar Resource Filament
php artisan make:filament-resource NomeDoModel

# Limpar caches
php artisan optimize:clear
```

## Testes e Qualidade

- Suite PHPUnit em `tests/` (Feature e Unit)
- Executar com `composer test` ou `php artisan test`
- **Importante:** Configurar banco de testes separado ou usar `:memory:` SQLite para não afetar dados dev

## Observações Finais

- **Documentação Completa:** `PLAN.MD` contém especificação detalhada, roadmap, benchmarks e decisões de arquitetura
- **Histórico:** Seção 18 do PLAN.MD documenta todas as entregas e customizações já realizadas
- **Sem Tailwind Arbitrário:** Projeto prioriza CSS custom em `public/css/` — manter consistência
- **Mercado Pago:** Único gateway implementado. Para adicionar outros (Stripe, Pagar.me), seguir padrão de `MercadoPagoService`

---

**Sempre priorize a identidade visual A&M e a experiência do usuário ao implementar novas funcionalidades.**
