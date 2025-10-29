<?php

namespace Database\Seeders;

use App\Models\Guest;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Message;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Guests
        $guests = [
            ['name' => 'João Silva', 'email' => 'joao@example.com', 'phone' => '(11) 99777-8899', 'companions_allowed' => 1],
            ['name' => 'Maria Santos', 'email' => 'maria@example.com', 'phone' => '(21) 98888-7766', 'companions_allowed' => 2],
            ['name' => 'Pedro Oliveira', 'email' => 'pedro@example.com', 'phone' => '(31) 98822-3344', 'companions_allowed' => 0],
            ['name' => 'Ana Lima', 'email' => 'ana.lima@example.com', 'phone' => '(61) 99122-4455', 'companions_allowed' => 1],
            ['name' => 'Carlos Souza', 'email' => 'carlos.souza@example.com', 'phone' => '(41) 99715-6677', 'companions_allowed' => 3],
            ['name' => 'Fernanda Ribeiro', 'email' => 'fernanda@example.com', 'phone' => '(51) 99334-5566', 'companions_allowed' => 2],
        ];
        $guestIds = [];
        foreach ($guests as $guestData) {
            $guest = Guest::create(array_merge($guestData, [
                'invite_code' => Guest::generateInviteCode(),
                'rsvp_status' => 'pending',
            ]));
            $guestIds[] = $guest->id;
        }

        // Products
        $products = [
            [
                'title' => 'Lua de Mel - Passagens Aéreas',
                'slug' => 'lua-de-mel-passagens',
                'description' => 'Ajude-nos a realizar o sonho da nossa lua de mel com uma contribuição para as passagens aéreas.',
                'price_cents' => 50000,
                'cover_image' => 'https://images.unsplash.com/photo-1529078155058-5d716f45d604?auto=format&fit=crop&w=900&q=80',
                'active' => true,
                'sort' => 1,
            ],
            [
                'title' => 'Lua de Mel - Hospedagem Charmosa',
                'slug' => 'lua-de-mel-hospedagem',
                'description' => 'Contribua para noites aconchegantes com vista para o mar durante a lua de mel.',
                'price_cents' => 32000,
                'cover_image' => 'https://images.unsplash.com/photo-1501117716987-c8e1ecb2101f?auto=format&fit=crop&w=900&q=80',
                'active' => true,
                'sort' => 2,
            ],
            [
                'title' => 'Jantar Romântico à Luz de Velas',
                'slug' => 'jantar-romantico',
                'description' => 'Uma noite especial com menu degustação para brindar o amor.',
                'price_cents' => 18000,
                'cover_image' => 'https://images.unsplash.com/photo-1529692236671-f1dc0278dd59?auto=format&fit=crop&w=900&q=80',
                'active' => true,
                'sort' => 3,
            ],
            [
                'title' => 'Passeio de Barco ao Pôr do Sol',
                'slug' => 'passeio-de-barco',
                'description' => 'Um passeio com brisa leve, música e vista inesquecível.',
                'price_cents' => 22000,
                'cover_image' => 'https://images.unsplash.com/photo-1468418254199-ace42f688875?auto=format&fit=crop&w=900&q=80',
                'active' => true,
                'sort' => 4,
            ],
            [
                'title' => 'Valor Livre',
                'slug' => 'valor-livre',
                'description' => 'Contribua com o valor que desejar para nos ajudar a realizar nossos sonhos.',
                'price_cents' => 0,
                'min_cents' => 5000,
                'max_cents' => 150000,
                'cover_image' => 'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?auto=format&fit=crop&w=900&q=80',
                'active' => true,
                'sort' => 999,
            ],
        ];
        $productIds = [];
        foreach ($products as $productData) {
            $product = Product::create($productData);
            $productIds[] = $product->id;
        }

        // Orders, OrderItems, Payments, Messages
        $messagesSamples = [
            'Que alegria celebrar esse amor com vocês! Desejamos uma vida cheia de aventuras.',
            'Vocês nasceram um para o outro. Obrigado por nos permitir fazer parte desse dia.',
            'Que a vida a dois seja sempre doce e cheia de risadas. Viva os noivos!',
            'Vocês inspiram o amor! Estamos ansiosos para celebrar cada minuto.',
            'Que a nova fase seja repleta de viagens, memórias e carinho sem fim.',
        ];

        for ($i = 1; $i <= 12; $i++) {
            $guestId = $guestIds[array_rand($guestIds)];
            $productId = $productIds[array_rand($productIds)];
            $qty = rand(1, 2);
            $unitPrice = Product::find($productId)->price_cents;
            $subtotal = $unitPrice * $qty;
            $fee = (int) round(($subtotal + 490) / (1 - 0.039) - $subtotal); // taxa simulada
            $total = $subtotal + $fee;

            $order = Order::create([
                'code' => 'ORD-' . strtoupper(Str::random(8)),
                'buyer_name' => Guest::find($guestId)->name,
                'buyer_email' => Guest::find($guestId)->email,
                'buyer_phone' => null,
                'message' => 'Parabéns aos noivos! Muito amor e felicidade! 🎉',
                'subtotal_cents' => $subtotal,
                'fee_cents' => $fee,
                'total_cents' => $total,
                'currency' => 'BRL',
                'status' => 'paid',
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'qty' => $qty,
                'unit_price_cents' => $unitPrice,
                'line_total_cents' => $subtotal,
            ]);

            Payment::create([
                'order_id' => $order->id,
                'gateway' => 'mercadopago',
                'method' => 'pix',
                'installments' => null,
                'gateway_charge_id' => 'ch_' . Str::random(10),
                'status' => 'paid',
                'paid_at' => now(),
                'raw_payload' => json_encode(['simulated' => true]),
            ]);

            Message::create([
                'order_id' => $order->id,
                'guest_name' => Guest::find($guestId)->name,
                'content' => $messagesSamples[array_rand($messagesSamples)],
                'is_public' => true,
                'approved' => true,
            ]);
        }
    }
}
