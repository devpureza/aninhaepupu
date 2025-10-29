<?php

namespace App\Services\Payments;

use App\Models\Order;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Resources\Preference;

class MercadoPagoService
{
    public function __construct()
    {
        if ($accessToken = Config::get('services.mercadopago.access_token')) {
            MercadoPagoConfig::setAccessToken($accessToken);
        }
    }

    public function createPreference(Order $order, array $payload): Preference
    {
        if (! Config::get('services.mercadopago.access_token')) {
            throw new \RuntimeException('Mercado Pago access token is not configured.');
        }

        // Em desenvolvimento Windows, usa API direta com SSL desabilitado
        if (app()->environment('local') && stripos(PHP_OS, 'WIN') === 0) {
            return $this->createPreferenceDirectly($order, $payload);
        }

        $client = new PreferenceClient();

        $items = Arr::get($payload, 'items');

        return $client->create([
            'items' => $items,
            'payer' => Arr::get($payload, 'payer'),
            'external_reference' => $order->code,
            'back_urls' => Arr::get($payload, 'back_urls'),
            'auto_return' => 'approved',
            'notification_url' => Arr::get($payload, 'notification_url'),
            'statement_descriptor' => Arr::get($payload, 'statement_descriptor', 'Ana & Mateus'),
            'payment_methods' => [
                'excluded_payment_types' => [
                    ['id' => 'ticket'], // Boleto
                    ['id' => 'atm'], // Débito Caixa
                    ['id' => 'debit_card'], // Cartão de débito
                    ['id' => 'bank_transfer'], // Transferência bancária (exceto Pix)
                    ['id' => 'prepaid_card'], // Cartão pré-pago
                ],
                'installments' => 12, // Até 12x no cartão de crédito
                'default_payment_method_id' => null, // Permite Pix como padrão
            ],
        ]);
    }

    private function createPreferenceDirectly(Order $order, array $payload): Preference
    {
        $client = new GuzzleClient(['verify' => false]);
        
        $response = $client->post('https://api.mercadopago.com/checkout/preferences', [
            'headers' => [
                'Authorization' => 'Bearer ' . Config::get('services.mercadopago.access_token'),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'items' => Arr::get($payload, 'items'),
                'payer' => Arr::get($payload, 'payer'),
                'external_reference' => $order->code,
                'back_urls' => Arr::get($payload, 'back_urls'),
                'auto_return' => 'approved',
                'notification_url' => Arr::get($payload, 'notification_url'),
                'statement_descriptor' => Arr::get($payload, 'statement_descriptor', 'Ana & Mateus'),
                'payment_methods' => [
                    'excluded_payment_types' => [
                        ['id' => 'ticket'],
                        ['id' => 'atm'],
                        ['id' => 'debit_card'],
                        ['id' => 'bank_transfer'],
                        ['id' => 'prepaid_card'],
                    ],
                    'installments' => 12,
                    'default_payment_method_id' => null,
                ],
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        
        $preference = new Preference();
        foreach ($data as $key => $value) {
            $preference->$key = $value;
        }
        
        return $preference;
    }

    public function findPayment(string $paymentId): ?array
    {
        try {
            // Em desenvolvimento Windows, usa API direta
            if (app()->environment('local') && stripos(PHP_OS, 'WIN') === 0) {
                $client = new GuzzleClient(['verify' => false]);
                $response = $client->get("https://api.mercadopago.com/v1/payments/{$paymentId}", [
                    'headers' => [
                        'Authorization' => 'Bearer ' . Config::get('services.mercadopago.access_token'),
                    ],
                ]);
                return json_decode($response->getBody()->getContents(), true);
            }

            $client = new PaymentClient();
            $payment = $client->get($paymentId);

            return $payment ? (array) $payment : null;
        } catch (\Throwable $exception) {
            Log::error('MercadoPagoService::findPayment error', [
                'payment_id' => $paymentId,
                'message' => $exception->getMessage(),
            ]);

            return null;
        }
    }
}
