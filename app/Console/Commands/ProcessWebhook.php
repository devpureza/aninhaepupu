<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Services\Payments\MercadoPagoService;
use Illuminate\Console\Command;

class ProcessWebhook extends Command
{
    protected $signature = 'webhook:process {payment_id}';
    protected $description = 'Processa manualmente um webhook do Mercado Pago pelo payment_id';

    public function handle(MercadoPagoService $mercadoPagoService)
    {
        $paymentId = $this->argument('payment_id');
        
        $this->info("🔍 Buscando pagamento {$paymentId} no Mercado Pago...");
        
        $paymentData = $mercadoPagoService->findPayment($paymentId);
        
        if (!$paymentData) {
            $this->error("❌ Pagamento não encontrado!");
            return Command::FAILURE;
        }
        
        $this->info("✅ Pagamento encontrado!");
        $this->line("   Status MP: " . ($paymentData['status'] ?? 'N/A'));
        $this->line("   External Reference: " . ($paymentData['external_reference'] ?? 'N/A'));
        
        $orderCode = data_get($paymentData, 'external_reference');
        $status = data_get($paymentData, 'status');
        
        $order = Order::where('code', $orderCode)->first();
        
        if (!$order) {
            $this->error("❌ Pedido {$orderCode} não encontrado!");
            return Command::FAILURE;
        }
        
        $this->info("📦 Pedido encontrado: {$order->code}");
        $this->line("   Status atual: {$order->status}");
        
        // Atualizar payment
        $order->payment?->update([
            'gateway_charge_id' => $paymentId,
            'status' => $status === 'approved' ? 'paid' : ($status === 'pending' ? 'pending' : 'failed'),
            'paid_at' => $status === 'approved' ? now() : null,
            'raw_payload' => $paymentData,
        ]);
        
        // Atualizar order
        if ($status === 'approved') {
            $order->update(['status' => 'paid']);
            $this->info("✅ Pedido marcado como PAGO!");
        } elseif ($status === 'pending') {
            $order->update(['status' => 'pending']);
            $this->warn("⏳ Pedido marcado como PENDENTE");
        } else {
            $order->update(['status' => 'failed']);
            $this->error("❌ Pedido marcado como FALHOU");
        }
        
        $this->newLine();
        $this->info("🎉 Webhook processado com sucesso!");
        
        return Command::SUCCESS;
    }
}
