## Agenda Telefonica ## 

## Gerar .env 
cp .env.example .env  

## Subir containers  
sail up -d  

## Chave da aplicação  
sail artisan key:generate  

## Migrations 
sail artisan migrate  

## Testes  
sail artisan test (utilizei o PHPUnit ao invés de Pest)  

## Comandos:  
composer require laravel/breeze --dev  
sail artisan breeze:install vue  
sail npm install  
sail npm run dev -- --host  
sail artisan migrate  

sail artisan make:model Contact -m  
sail artisan make:policy ContactPolicy --model=Contact  
sail artisan make:request StoreContactRequest  
sail artisan make:request UpdateContactRequest  
sail artisan make:controller ContactController  

sail artisan storage:link  

## Dados para testar  
sail artisan db:seed DatabaseSeeder  
Email: teste01@exemplo.com ou teste02@exemplo.com  
Senha: 123456789  