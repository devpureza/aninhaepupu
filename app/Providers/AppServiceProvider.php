<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MercadoPago\MercadoPagoConfig;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configurar certificado SSL para Mercado Pago no Windows
        if (app()->environment('local') && stripos(PHP_OS, 'WIN') === 0) {
            $cacertPath = storage_path('cacert.pem');
            if (file_exists($cacertPath)) {
                putenv('CURL_CA_BUNDLE=' . $cacertPath);
            }
        }
    }
}
