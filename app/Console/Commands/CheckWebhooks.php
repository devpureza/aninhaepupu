<?php

namespace App\Console\Commands;

use App\Models\WebhookLog;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Console\Command;

class CheckWebhooks extends Command
{
    protected $signature = 'webhooks:check';
    protected $description = 'Verifica últimos webhooks recebidos';

    public function handle()
    {
        $this->info('🔍 Verificando webhooks...');
        $this->newLine();

        // Últimos webhooks
        $webhooks = WebhookLog::latest()->take(5)->get();
        
        if ($webhooks->isEmpty()) {
            $this->warn('❌ Nenhum webhook recebido ainda');
        } else {
            $this->info("✅ Últimos {$webhooks->count()} webhooks:");
            foreach ($webhooks as $webhook) {
                $this->line("  • ID: {$webhook->id} | Criado: {$webhook->created_at}");
            }
        }

        $this->newLine();

        // Último pagamento
        $payment = Payment::latest()->first();
        if ($payment) {
            $this->info("💳 Último pagamento:");
            $this->line("  • ID: {$payment->id}");
            $this->line("  • Status: {$payment->status}");
            $this->line("  • Gateway ID: {$payment->gateway_charge_id}");
            $this->line("  • Criado: {$payment->created_at}");
        }

        $this->newLine();

        // Último pedido
        $order = Order::latest()->first();
        if ($order) {
            $this->info("📦 Último pedido:");
            $this->line("  • Código: {$order->code}");
            $this->line("  • Status: {$order->status}");
            $this->line("  • Comprador: {$order->buyer_name}");
            $this->line("  • Total: R$ " . number_format($order->total_cents / 100, 2, ',', '.'));
        }

        return Command::SUCCESS;
    }
}
