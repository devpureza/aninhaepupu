<x-filament::widget>
    <div class="am-dashboard">
        <div class="am-dashboard__overview">
            <div class="am-dashboard__intro">
                <div class="am-dashboard__header">
                    <img src="{{ asset('monograma-am.svg') }}" alt="Monograma A&M" class="am-dashboard__monogram">
                    <div>
                        <p class="am-dashboard__eyebrow">Ana &amp; Mateus</p>
                        <p class="am-dashboard__subtitle">{{ now()->locale('pt_BR')->translatedFormat('d \\d\\e F \\d\\e Y') }}</p>
                    </div>
                </div>

                <div class="am-dashboard__card am-dashboard__card--highlight">
                    <span class="am-dashboard__label">Total arrecadado</span>
                    <span class="am-dashboard__value am-dashboard__value--big">R$ {{ number_format($totalArrecadado, 2, ',', '.') }}</span>
                    <span class="am-dashboard__hint">Inclui taxas repassadas aos pagadores.</span>
                </div>
            </div>

            <div class="am-dashboard__stats">
                <div class="am-dashboard__card">
                    <span class="am-dashboard__label">Pedidos confirmados</span>
                    <span class="am-dashboard__value">{{ $numPedidos }}</span>
                    <span class="am-dashboard__hint">Pagamentos concluídos e registrados.</span>
                </div>
                <div class="am-dashboard__card">
                    <span class="am-dashboard__label">Ticket médio</span>
                    <span class="am-dashboard__value">R$ {{ number_format($ticketMedio, 2, ',', '.') }}</span>
                    <span class="am-dashboard__hint">Valor líquido por pedido.</span>
                </div>
                <div class="am-dashboard__card">
                    <span class="am-dashboard__label">Convidados na base</span>
                    <span class="am-dashboard__value">{{ $numConvidados }}</span>
                    <span class="am-dashboard__hint">Inclui titulares e agregados.</span>
                </div>
            </div>
        </div>

        <div class="am-dashboard__panels">
            <div class="am-dashboard__panel">
                <div class="am-dashboard__panel-header">
                    <span class="am-dashboard__panel-icon" aria-hidden="true">🌿</span>
                    <h3 class="am-dashboard__panel-title">Top itens do momento</h3>
                </div>
                <ul class="am-dashboard__list">
                    @forelse ($topItens as $item)
                        <li class="am-dashboard__list-item">
                            <div>
                                <p class="am-dashboard__item-title">{{ $item->title }}</p>
                                @if ($item->description)
                                    <p class="am-dashboard__item-description">{{ $item->description }}</p>
                                @endif
                            </div>
                            <span class="am-dashboard__badge">
                                R$ {{ number_format($item->price_cents / 100, 2, ',', '.') }}
                            </span>
                        </li>
                    @empty
                        <li class="am-dashboard__empty">Nenhum item cadastrado ainda.</li>
                    @endforelse
                </ul>
            </div>

            <div class="am-dashboard__panel">
                <div class="am-dashboard__panel-header">
                    <span class="am-dashboard__panel-icon" aria-hidden="true">💌</span>
                    <h3 class="am-dashboard__panel-title">Últimas mensagens recebidas</h3>
                </div>
                <ul class="am-dashboard__list">
                    @forelse ($ultimasMensagens as $msg)
                        <li class="am-dashboard__list-item">
                            <div>
                                <p class="am-dashboard__item-title">{{ $msg->guest_name }}</p>
                                <p class="am-dashboard__item-description">“{{ $msg->content }}”</p>
                            </div>
                            <span class="am-dashboard__badge am-dashboard__badge--soft">
                                {{ $msg->created_at?->locale('pt_BR')->diffForHumans() }}
                            </span>
                        </li>
                    @empty
                        <li class="am-dashboard__empty">Ainda não recebemos mensagens públicas.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-filament::widget>
