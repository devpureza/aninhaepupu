<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Services\Payments\MercadoPagoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class CheckoutController extends Controller
{
    public function store(Product $product, CheckoutRequest $request, MercadoPagoService $mercadoPagoService): RedirectResponse
    {
        $data = $request->validated();

        $amountCents = $product->price_cents;

        if ($product->allowsCustomAmount()) {
            $customAmount = (int) round(($data['custom_amount'] ?? 0) * 100);

            $min = $product->min_cents ?? 0;
            $max = $product->max_cents ?? $customAmount;

            if ($customAmount < $min || $customAmount > $max) {
                return back()->withErrors([
                    'custom_amount' => 'Informe um valor entre R$ ' . number_format($min / 100, 2, ',', '.') . ' e R$ ' . number_format($max / 100, 2, ',', '.'),
                ])->withInput();
            }

            $amountCents = max($customAmount, 100);
        }

        if ($amountCents <= 0) {
            return back()->withErrors(['custom_amount' => 'Valor inválido para o presente selecionado.'])->withInput();
        }

        $quantity = 1;

        $order = DB::transaction(function () use ($product, $data, $amountCents, $quantity) {
            $order = Order::create([
                'code' => Order::generateCode(),
                'buyer_name' => $data['name'],
                'buyer_email' => $data['email'],
                'buyer_phone' => $data['phone'] ?? null,
                'message' => $data['message'] ?? null,
                'subtotal_cents' => $amountCents * $quantity,
                'fee_cents' => 0,
                'total_cents' => $amountCents * $quantity,
                'currency' => 'BRL',
                'status' => 'pending',
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'qty' => $quantity,
                'unit_price_cents' => $amountCents,
                'line_total_cents' => $amountCents * $quantity,
            ]);

            Payment::create([
                'order_id' => $order->id,
                'gateway' => 'mercadopago',
                'method' => 'card',
                'installments' => null,
                'status' => 'pending',
            ]);

            return $order;
        });

        try {
            $preference = $mercadoPagoService->createPreference($order, [
                'items' => [[
                    'title' => $product->title,
                    'quantity' => $quantity,
                    'unit_price' => $amountCents / 100,
                    'currency_id' => 'BRL',
                ]],
                'payer' => [
                    'name' => $data['name'],
                    'email' => $data['email'],
                ],
                'back_urls' => [
                    'success' => route('checkout.success', $order->code),
                    'pending' => route('checkout.pending', $order->code),
                    'failure' => route('checkout.failure', $order->code),
                ],
                'notification_url' => route('checkout.webhook', 'mercadopago'),
                'statement_descriptor' => 'Ana & Mateus',
            ]);
        } catch (\Throwable $exception) {
            Log::error('Mercado Pago preference error', [
                'order_id' => $order->id,
                'message' => $exception->getMessage(),
            ]);

            return back()->withErrors([
                'name' => 'Não foi possível iniciar o pagamento agora. Tente novamente em instantes.',
            ])->withInput();
        }

        $order->payment->update([
            'gateway_charge_id' => $preference->id,
        ]);

        return redirect()->away($preference->init_point ?? $preference->sandbox_init_point);
    }

    public function success(Order $order)
    {
        return view('checkout.success', compact('order'));
    }

    public function pending(Order $order)
    {
        return view('checkout.pending', compact('order'));
    }

    public function failure(Order $order)
    {
        return view('checkout.failure', compact('order'));
    }

    public function webhook(Request $request, string $gateway, MercadoPagoService $mercadoPagoService)
    {
        $payload = $request->all();

        Log::info('Mercado Pago webhook received', $payload);

        $type = $payload['type'] ?? $payload['action'] ?? null;
        $paymentId = data_get($payload, 'data.id');

        if ($gateway !== 'mercadopago' || $type !== 'payment' || ! $paymentId) {
            return response()->json(['status' => 'ignored']);
        }

        $paymentData = $mercadoPagoService->findPayment($paymentId);

        if (! $paymentData) {
            return response()->json(['status' => 'not_found'], 404);
        }

        $orderCode = data_get($paymentData, 'external_reference');
        $status = data_get($paymentData, 'status');

        $order = Order::where('code', $orderCode)->first();

        if (! $order) {
            return response()->json(['status' => 'order_not_found'], 404);
        }

        $order->payment?->update([
            'gateway_charge_id' => $paymentId,
            'status' => $status === 'approved' ? 'paid' : ($status === 'pending' ? 'pending' : 'failed'),
            'paid_at' => $status === 'approved' ? now() : null,
            'raw_payload' => $paymentData,
        ]);

        if ($status === 'approved') {
            $order->update(['status' => 'paid']);
        } elseif ($status === 'pending') {
            $order->update(['status' => 'pending']);
        } else {
            $order->update(['status' => 'failed']);
        }

        return response()->json(['status' => 'ok']);
    }
}
