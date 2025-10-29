#!/bin/bash

# Script de post-deploy para Laravel Cloud
# Este script é executado automaticamente após cada deploy

echo "🚀 Iniciando configurações pós-deploy..."

# Criar diretórios necessários se não existirem
mkdir -p public/css
mkdir -p public/build
mkdir -p storage/app/public
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs

# Copiar CSS customizado do Filament se necessário
if [ ! -f public/css/filament-custom.css ]; then
    echo "📄 Criando arquivo CSS customizado do Filament..."
    touch public/css/filament-custom.css
fi

# Executar upgrade do Filament (após garantir que arquivos existem)
echo "🎨 Atualizando assets do Filament..."
php artisan filament:upgrade || true

# Limpar e otimizar caches
echo "🧹 Limpando caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Otimizar aplicação para produção
echo "⚡ Otimizando aplicação..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Link do storage (caso não exista)
if [ ! -L public/storage ]; then
    echo "🔗 Criando link simbólico do storage..."
    php artisan storage:link
fi

# Executar migrations (com flag --force para produção)
echo "🗄️  Executando migrations..."
php artisan migrate --force --no-interaction

echo "✅ Deploy concluído com sucesso!"
