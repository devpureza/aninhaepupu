<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Guest;
use App\Models\Message;
use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cache;

class WeddingStatsWidget extends Widget
{
    protected string $view = 'filament.admin.widgets.wedding-stats-widget';

    protected static ?string $pollingInterval = '60s';

    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return Cache::remember('wedding_stats_widget_data', now()->addSeconds(60), function () {
            $totalArrecadado = Order::sum('total_cents') / 100;
            $numPedidos = Order::count();
            $ticketMedio = $numPedidos ? ($totalArrecadado / $numPedidos) : 0;
            $topItens = Product::orderByDesc('price_cents')->take(3)->get();
            $ultimasMensagens = Message::orderByDesc('created_at')->take(3)->get();
            $numConvidados = Guest::count();

            return [
                'totalArrecadado' => $totalArrecadado,
                'numPedidos' => $numPedidos,
                'ticketMedio' => $ticketMedio,
                'topItens' => $topItens,
                'ultimasMensagens' => $ultimasMensagens,
                'numConvidados' => $numConvidados,
            ];
        });
    }
}
