#!/bin/bash
echo "Back - Iniciando o Endpoint da Aplicação"

if ! [ -f ".env" ]; then
    echo "Arquivo '.env' não encontrado - Gerando arquivo"
    cp .env.example .env
fi

echo "Instalando as dependências com o composer..."
composer update

echo "Permissões de acesso a pasta vendor"
chmod -R 777 vendor

echo "Desabilita debug em prod"
sed -i "s/APP_DEBUG=true/APP_DEBUG=false/g" .env

echo "Permissões de acesso a pasta storage"
chmod -R 777 storage

echo "Limpando o cache das rotas e views"
php artisan view:clear

echo "Configurando o cache"
php artisan key:generate
php artisan optimize:clear

echo "Executando migrates e seeds"
php artisan migrate:fresh --seed

echo "Iniciando cron"
service cron start

echo "Back - Finzalizando o Endpoint da Application"