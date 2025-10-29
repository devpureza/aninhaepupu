# Site do Casamento Ana & Mateus — Plano de Projeto

Autor: Mateus Pureza • Noiva: Ana Carolina  
Stack: Laravel 11 + MySQL + CSS custom

---

## 1) Objetivos
- Criar um site elegante e funcional alinhado à identidade visual do casamento. 
- Permitir arrecadação via cotas/presentes simbólicos e doações (Pix e cartão, com repasse de taxas ao pagador). 
- Oferecer experiência completa para convidados: informações do evento, RSVP, mensagens, mapa e galeria. 
- Disponibilizar um painel administrativo para gestão de conteúdo, produtos/cotas, pedidos, pagamentos, mensagens e relatórios.

---

## 2) Benchmarks e Referências (curadoria)
Estes serviços e sites ajudam a mapear padrões, fluxos de checkout e ideias de UX/visual:

- Brasil
  - iCasei (https://www.icasei.com.br/) – sites, RSVP, lista de presentes, cotas, pagamento com Pix/cartão, mensagens. 
  - Casare.me (https://www.casare.me/) – foco em lista de presentes/cotas, domínio personalizado, RSVP e app. 
  - Zankyou Brasil (https://www.zankyou.com.br/) – lista de presentes e wedding website com foco em cotas e saque. 
  - Casamentos.com.br (https://www.casamentos.com.br/) – diretório e sites de casamento simples com RSVP. 

- Internacional
  - WithJoy (https://withjoy.com/) – UX limpa; ótimo fluxo de RSVP e informações de viagem. 
  - Zola (https://www.zola.com/) – lista + cotas, checkout claro, mensagens, timeline do evento. 
  - The Knot (https://www.theknot.com/) – templates variados, foco em organização e RSVP. 

Padrões recorrentes observados
- Página inicial com herói visual, contagem regressiva e navegação direta para RSVP, Local, Lista/Cotas. 
- Sessões essenciais: História, Cronograma, Localização/Mapa, RSVP, Presentes/Cotas, Dicas de Hospedagem/Transporte, Mensagens, Galeria e FAQ. 
- Lista de presentes simbólicos com valores e imagens, e opção “valor livre”. 
- Checkout simplificado com seleção Pix/cartão e cálculo de taxas transparente. 
- Dashboard com métricas: valor arrecadado, média por doação, itens mais comprados, últimos recados. 

---

## 3) Identidade Visual (tokens e diretrizes)
Baseada nas imagens recebidas (A&M).

### 3.1 Paleta principal
- Calmaria: `#faf9f5` (fundo claro principal)
- Confiança: `#e0decd` (fundo alternativo e bordas suaves)
- Pôr do Sol: `#8e5b32` (destaques quentes/terrosos)
- Olhinhos: `#d38c4a` (acentos, CTAs secundários)
- Verde Oliva: `#5f6848` (cor de marca primária)
- Esperança: `#7e957e` (realces, estados hover)

Neutros de apoio
- Preto suave: `#111111`
- Cinza 600: `#646B63`
- Cinza 200: `#E8E8E5`

Gradientes sugeridos
- Oliva → Esperança: `linear-gradient(135deg, #5f6848 0%, #7e957e 100%)`

### 3.2 Tipografia
- Títulos: Lunery (serif display). Se a licença não permitir web, usar fallback “Cormorant Garamond” (Google Fonts). 
- Textos e numeração leve: Nord Thin (geométrica). Fallback sugerido: “Manrope” ou “Poppins Light”. 
- Sistema CSS: `font-family: 'Lunery', 'Cormorant Garamond', serif;` e `font-family: 'Nord', 'Manrope', system-ui, sans-serif;`

### 3.3 Componentes e estilo
- Botões: 
  - Primário: fundo Verde Oliva, texto claro, hover em Esperança. 
  - Secundário: borda Oliva, texto Oliva, hover com leve fill `#e0decd`. 
- Cartões: radius 12px, sombra suave 8/16, bordas `#e0decd`. 
- Inputs: altura 44px, radius 10px, foco com outline `#7e957e`. 
- Ícones e ilustrações: traço orgânico (folhas/ramas), baixa saturação em Oliva. 

### 3.4 Tokens (CSS custom properties)
```css
:root{
  --am-bg: #faf9f5;
  --am-bg-alt: #e0decd;
  --am-olive: #5f6848;
  --am-olive-2: #7e957e;
  --am-sunset: #8e5b32;
  --am-amber: #d38c4a;
  --am-text: #111111;
  --am-muted: #646B63;
  --am-border: #E8E8E5;
  --radius: 12px;
}
```

Uso do monograma
- Preferir fundo Oliva com monograma claro para hero e favicon.  
- Evitar escalas menores que 24px; manter área de respiro.

---

## 4) Modelos de Arrecadação (com padrões de mercado)

### 4.1 Opções de monetização
- Cotas de experiências (lua de mel, itens simbólicos) – padrão iCasei/Zola; ticket médio mais alto com storytelling. 
- Presentes simbólicos (sem entrega física) – conversão maior; permite metas. 
- Doação de valor livre – converter visitantes indecisos. 
- “Lista de loja” externa (link-out) – opcional. 

### 4.2 Meios de pagamento (Brasil)
- Pix: QR dinâmico, expiração e conciliação automática. 
- Cartão de crédito: 1x e parcelado (exibir juros e custo). 
- Boleto: opcional; hoje menos usado para presentes. 

Gateways recomendados (com APIs maduras)
- Stripe (suporte no Brasil a cartão e Pix via parceiros). 
- Pagar.me/Stone (cartão, Pix e antifraude). 
- Mercado Pago (cartão e Pix, fácil onboarding). 
- Gerencianet/Efaz (Pix forte, webhooks claros). 

Critérios de escolha
- Facilidade Laravel (SDKs), Pix dinâmico, split de taxas para o pagador, webhooks estáveis, taxas competitivas e suporte a parcelamento. 

### 4.3 Repassando taxas ao pagador
Se a taxa for percentual `t` + fixa `f`, para que o casal receba `R` líquido:  
Valor a cobrar `C = (R + f) / (1 - t)`.  
Exibir: “Você paga R$C (inclui taxas) — o casal recebe R$R”. 

### 4.4 Mensagem do comprador
- Campo obrigatório opcional: até 280 caracteres; emojis permitidos; opção de privacidade (pública/noivos). 
- Mostrar no mural (com moderação) e no dashboard. 

---

## 5) Funcionalidades e Sitemap

Páginas
- Home (hero com monograma, data, contagem regressiva, CTA para RSVP e Cotinhas)
- Nossa História
- Cronograma do dia
- Local e Mapa (Google Maps + instruções, dress code, estacionamento)
- RSVP (formulário por convidado; restrições/alergias; número de acompanhantes)
- Presentes & Cotas (lista
- Checkout (Pix/cartão, parcelado, taxas do pagador, mensagem)
- Mural de Mensagens (moderação)
- Galeria (pré e pós-evento)
- Dicas de Hospedagem/Transporte
- FAQ e Contato

Fluxos
- RSVP: convite → formulário → confirmação por e‑mail/WhatsApp → dashboard registra status. 
- Compra/Doação: item/cota → checkout → pagamento → webhook → recibo por e‑mail → mural opcional. 
- Admin: CRUD de itens/cotas, preços, estoque simbólico, pedidos, webhooks, exportações, configurações (taxas, chaves Pix, templates de e‑mail). 

---

## 6) Requisitos Funcionais
- RF-01 Site público com conteúdo estático e dinâmico gerenciável. 
- RF-02 Lista de presentes/cotas com valores e metas. 
- RF-03 Checkout Pix e cartão, com parcelamento e repasse de taxas ao pagador. 
- RF-04 Mensagem do comprador com opção de publicar no mural. 
- RF-05 RSVP com confirmação e gestão de acompanhantes. 
- RF-06 Dashboard com KPIs, pedidos, itens, mensagens e exportações (CSV). 
- RF-07 Moderação de mural e anti-spam (reCAPTCHA/Turnstile). 
- RF-08 Notificações por e‑mail (pedidos, mensagens, RSVP). 

Requisitos Não Funcionais
- RNF-01 Acessibilidade WCAG AA mínima. 
- RNF-02 TTFB < 200ms em páginas cacheadas. 
- RNF-03 99,5% uptime no período de convite ao evento. 
- RNF-04 LGPD: consentimento para mensagens/contatos; retenção controlada. 

---

## 7) Arquitetura Técnica (Laravel)

Versões e ferramentas
- PHP 8.2+, Laravel 11, Composer 2, Node 20, Vite. 
- Banco: SQLite (desenvolvimento) → MySQL 8 ou Postgres 15 (produção). 
- Admin UI: FilamentPHP (rápido e nativo Laravel) ou Laravel Nova. 
- CSS: folha custom com tokens; opcionalmente Sass.

Camadas
- App (Eloquent Models, Policies, Services)
- Domain/Payments (estratégias por gateway: Stripe, Pagarme, etc.)
- Domain/Checkout (cálculo de taxas, parcelas, totals)
- Http (Controllers, Requests, Resources)
- View (Blade + componentes) 

Infra e serviços
- Files: S3/Backblaze para imagens. 
- E-mail: Resend/SES. 
- Observabilidade: Sentry + Laravel Telescope em staging. 
- Deploy: Laravel Forge + VPS (Nginx) ou Railway/Render. 

Webhooks
- `/webhooks/payments/{gateway}` para atualização de status (Pix visto/pago, cartão autorizado/liquidado). 
- Assinatura/HMAC verificada; logs em tabela de auditoria. 

### 7.1 Modelagem de Dados (proposta)
- `users` (admins)
  - id, name, email, password, two_factor_secret, roles
- `guests`
  - id, name, email, phone, household_id, invite_code, rsvp_status, companions_allowed, companions_confirmed, notes
- `rsvps`
  - id, guest_id, attending:boolean, companions:int, dietary_notes, created_at
- `products` (presentes/cotas simbólicas)
  - id, slug, title, description, cover_image, price_cents, min_cents, max_cents, stock:int|null, active:boolean, sort
- `orders`
  - id, code, buyer_name, buyer_email, buyer_phone, message, subtotal_cents, fee_cents, total_cents, currency, status
- `order_items`
  - id, order_id, product_id, qty, unit_price_cents, line_total_cents
- `payments`
  - id, order_id, gateway, method:pix|card, installments:int|null, gateway_charge_id, status, paid_at, raw_payload(json)
- `messages`
  - id, order_id|null, guest_name, content, is_public:boolean, approved:boolean
- `webhook_logs`
  - id, gateway, event, signature_valid:boolean, payload(json)

Índices: por `orders.code`, `payments.gateway_charge_id`, `guests.invite_code`.

### 7.2 Regras e Cálculos
- Total do pedido = soma dos itens + taxa (calculada para repasse ao pagador). 
- Cálculo de taxa (exemplo): `fee = floor((subtotal_cents + fee_fixed) / (1 - t) - subtotal_cents)`; exibir antes de pagar. 
- Parcelas: simular CET informado pelo gateway; exibir opções 1x..Nx com total por parcela. 

---

## 8) UX de Checkout
- Passo 1: Resumo dos itens/cotas (+ valor livre). 
- Passo 2: Dados do comprador (nome, e‑mail, telefone, mensagem, publicar ou não, LGPD consent). 
- Passo 3: Escolha Pix/cartão; em cartão, selecionar parcelas e ver total com taxa. 
- Passo 4: Confirmação + recibo; Pix mostra QR dinâmico e tempo de expiração. 

Estados
- Pendente (aguardando pagamento) → Pago → Falhou/Expirou → Estornado (se aplicável). 
- Mensagens com moderação: novas ficam “pendentes” até aprovação.

---

## 9) Painel Administrativo (Filament/Nova)
- Dashboard: total arrecadado, número de pedidos, ticket médio, top itens, últimas mensagens. 
- Pedidos e Pagamentos: filtro por status, exportação CSV, reenvio de recibo. 
- Produtos/Cotas: CRUD, upload de imagem, estoque simbólico, agrupamento por categoria. 
- Conteúdo: Páginas estáticas (história, cronograma, dicas), Galeria e Mural. 
- Convidados/RSVP: importação CSV, confirmação manual, edição de restrições alimentares. 
- Configurações: chaves de gateway, templates de e‑mail, controle de taxa, domínio, SEO. 
- Auditoria: webhooks e logs. 

---

## 10) Segurança, Privacidade e Conformidade
- HTTPS obrigatório; headers de segurança (HSTS, CSP, X-Frame-Options). 
- CSRF/Laravel, validações server-side, rate limit em formulários públicos. 
- Proteção de webhook com assinatura e reprocessamento idempotente. 
- LGPD: consent para mensagens/exibição pública; retenção de dados pós‑evento; política de privacidade. 

---

## 11) SEO, Performance e Acessibilidade
- SEO: metatags Open Graph, schema.org Event, sitemap.xml, robots.txt. 
- Imagens otimizadas (AVIF/WebP), lazy loading, sizes responsivos. 
- Cache de páginas públicas, ETags, preconnect de fontes. 
- A11y: contraste mínimo AA; navegação por teclado; labels e aria‑attrs. 

---

## 12) Roadmap (Sprints sugeridos)

Sprint 0 — Setup (1 semana)
- Repositório, CI/CD, ambiente (dev/staging/prod), seeds, autenticação admin (Filament/Breeze), tokens de design. 

Sprint 1 — Estrutura pública (1–2 semanas)
- Páginas: Home, História, Cronograma, Local+Mapa, FAQ. 
- Tema/CSS final, componentes de UI e acessibilidade. 

Sprint 2 — Lista/Cotas + Checkout base (2 semanas)
- CRUD de produtos/cotas, listagem e carrinho. 
- Checkout simulado (sem gateway) com cálculo de taxa e mensagem. 

Sprint 3 — Pagamentos (2 semanas)
- Integração do gateway escolhido (Pix + cartão). 
- Webhooks, recibo por e‑mail e mural de mensagens. 

Sprint 4 — RSVP + Painel completo (1–2 semanas)
- Fluxo de RSVP, importação de convidados, relatórios e exportações. 

Sprint 5 — Polimento e Go‑Live (1 semana)
- Testes E2E, acessibilidade, SEO, compressão, monitoramento e migração de DNS.

---

## 13) Backlog de Itens (priorizados)
- P0: Checkout Pix/cartão com repasse de taxas; Webhook; Mensagem do comprador; Dashboard de pedidos. 
- P0: Lista de cotas com valor livre; Página Home finalizada; RSVP. 
- P1: Galeria pós‑evento; Dicas de hospedagem; Exportações avançadas. 
- P2: Integração WhatsApp para envio de confirmações; Cupom/“chave de presente”. 

---c

## 14) Entregáveis
- Repositório Laravel com módulos: Público, Checkout, Payments, Admin. 
- CSS custom com tokens da paleta e tipografia definida. 
- Documentação de ambiente (.env.example), scripts de setup e guias de operação.

---

## 15) Próximas Decisões
- Escolher gateway (Stripe, Pagar.me, Mercado Pago ou Gerencianet). 
- Confirmar uso/licença das fontes Lunery e Nord Thin para web ou aplicar fallbacks. 
- Definir hospedagem (Forge+VPS ou PaaS) e domínio. 

---

## 16) Anexos Úteis (snippets)

### 16.1 Exemplo de cálculo de taxa (PHP)
```php
function cobrarComTaxa(float $liquido, float $taxaPercent, float $taxaFixa): float {
    $t = $taxaPercent; // ex.: 0.039 para 3,9%
    return round(($liquido + $taxaFixa) / (1 - $t), 2);
}
```

### 16.2 Estrutura de rotas (rascunho)
```text
GET /                -> Home
GET /historia        -> Página estática
GET /cronograma      -> Página estática
GET /local           -> Mapa e detalhes
GET /presentes       -> Lista/cotas
POST /carrinho       -> Adicionar item
GET /checkout        -> Resumo e dados
POST /checkout/pagar -> Inicia pagamento (Pix/cartão)
POST /webhooks/payments/{gateway}
GET /rsvp            -> Form RSVP
POST /rsvp           -> Registrar presença
GET /mural           -> Mensagens

Admin (Filament) em /admin
```

### 16.3 Template de e-mail (recibo) — tópicos
- Saudações com monograma A&M. 
- Itens/cotas adquiridos, valor total e mensagem enviada. 
- Botão “ver mensagem no mural” (se pública). 
- Assinatura com paleta e tipografia.

---

## 17) Resumo
Este plano consolida benchmarks do mercado, tokens da identidade visual A&M, arquitetura em Laravel, modelagem de dados, fluxos de arrecadação com Pix/cartão (taxas pagas pelo comprador), e um roadmap pragmático até o go‑live. Com a aprovação do gateway e da hospedagem, iniciamos o Sprint 0 e entregamos o esqueleto do projeto em poucos dias.

---

## 18) Histórico de Entregas e Customizações

- Ambiente Laravel 12, PHP 8.4, Composer 2, Node/Vite configurado.
- Banco de dados SQLite para desenvolvimento, .env ajustado.
- Migrations e models criados para todas as entidades principais.
- Seeds simulados para Guests, Products, Orders, Payments, Messages.
- Filament 4 instalado e configurado como painel admin.
- Resources Filament gerados para todas as entidades.
- Painel admin customizado:
  - Cores do projeto aplicadas.
  - Logo/monograma SVG integrado.
  - Fontes customizadas preparadas.
  - Remoção de branding Filament.
  - Widget exclusivo com KPIs do casamento (total arrecadado, pedidos, ticket médio, convidados, top itens, últimas mensagens).
  - Cards individuais para cada KPI, layout responsivo e visual premium.
  - Menu lateral traduzido para português.
  - Ícones temáticos adicionados ao menu.
  - Remoção do widget padrão de boas-vindas.
- Correção de erros de métodos não suportados e propriedades static.
- Melhoria contínua do layout do dashboard admin.
- Ajustes aplicados:
  - Corrigimos as tabelas do Filament para usarem a API correta (`actions`/`bulkActions`) e exibirem valores monetários, booleanos e status com melhor formatação.
  - O provider do painel agora aplica a paleta com `Color::hex`, evita widgets duplicados e registra o CSS custom (`public/css/filament-custom.css`) via assets.
  - Revisamos o widget de estatísticas (cache leve de 60s) e o template Blade para garantir estilos consistentes sem classes Tailwind personalizadas quebradas.
  - CSS custom concentrado em `public/css/filament-custom.css` (fontes + tokens) mantendo os assets nativos do Filament carregados.
  - Dashboard redesenhado com layout premium (cards, grades e painéis) e estilos dedicados `am-dashboard*`.
  - Widget principal ajustado para ocupar toda a largura (`columnSpan = 'full'`) e CSS refinado (grids fixos para overview/stats, responsividade ≤1024px).
  - Namespaces das ações Filament corrigidos para `Filament\Actions\*`, evitando erros com `EditAction`/`DeleteBulkAction`.
  - Formulários Filament estruturados com seções, validações e uploads (`Guests`, `Messages`, `Products`, `Orders`, `Payments`).
- Home pública dinamizada: controller dedicado coleta métricas, top itens e recados; layout da home atualizado com cartões, progress bar da meta e mosaicos.
- Home refinada com seções adicionais (história, timeline, CTA RSVP), placeholders de imagem e estilos responsivos alinhados aos tokens.
- Páginas públicas finalizadas com conteúdo real: história, cronograma, local, presentes, mural, FAQ e privacidade – todas com layout responsivo alinhado ao design system.
- Fluxos “RSVP” e “Mural de mensagens” disponíveis ao público, com validação, honeypot anti-spam e moderação no painel.
- Controllers específicos no namespace `App\Http\Controllers\Site` organizam dados e cache das páginas (Story, Schedule, Location, Gifts, Messages, Rsvp, FAQ, Privacy).
- Seeds de demonstração atualizados com convidados, mensagens variadas e imagens públicas (Unsplash) para cotas.

