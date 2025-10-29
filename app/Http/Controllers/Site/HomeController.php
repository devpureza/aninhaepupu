<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\Message;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $cacheTtl = now()->addMinutes(5);

        $stats = Cache::remember('site.home.stats', $cacheTtl, function () {
            $totalCents = Order::where('status', 'paid')->sum('total_cents');
            $total = $totalCents / 100;

            $paidOrders = Order::where('status', 'paid')->count();
            $ticketMedio = $paidOrders ? $total / $paidOrders : 0;

            $goalCents = (int) env('WEDDING_GOAL_CENTS', 500000);
            $goal = $goalCents / 100;
            $percentualMeta = $goal > 0 ? min(100, round(($total / $goal) * 100, 1)) : null;

            return [
                'total_arrecadado' => $total,
                'pedidos_confirmados' => $paidOrders,
                'ticket_medio' => $ticketMedio,
                'convidados_confirmados' => Guest::where('rsvp_status', 'confirmed')->count(),
                'meta' => $goal,
                'percentual_meta' => $percentualMeta,
            ];
        });

        $topProducts = Cache::remember('site.home.top_products', $cacheTtl, function () {
            return Product::query()
                ->where('active', true)
                ->orderBy('sort')
                ->take(4)
                ->get(['id', 'title', 'slug', 'description', 'price_cents', 'cover_image']);
        });

        $latestMessages = Cache::remember('site.home.messages', $cacheTtl, function () {
            return Message::forWall()
                ->take(6)
                ->get(['id', 'guest_name', 'content', 'created_at']);
        });

        return view('home', [
            'stats' => $stats,
            'topProducts' => $topProducts,
            'latestMessages' => $latestMessages,
        ]);
    }
}
