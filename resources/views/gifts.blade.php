@extends('layouts.app')

@section('title', 'Presentes & Cotinhas | Ana & Mateus')

@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
@endphp

@section('content')
<section class="section">
    <div class="container container-sm text-center">
        <span class="home-story__eyebrow">Com carinho</span>
        <h1 class="section-title">Presentes &amp; cotinhas</h1>
        <p class="home-intro">
            Sua presença é o que mais importa. Mas, se quiser nos presentear, preparamos experiências e momentos
            especiais da nossa lua de mel para você fazer parte.
        </p>
    </div>
</section>

@if($products->isNotEmpty())
<section class="section section-alt">
    <div class="container">
        <div class="gifts-grid">
            @foreach($products as $product)
                @php
                    $imageUrl = null;
                    if ($product->cover_image) {
                        $imageUrl = Str::startsWith($product->cover_image, ['http://', 'https://'])
                            ? $product->cover_image
                            : Storage::disk('public')->url($product->cover_image);
                    }
                    $allowsCustom = $product->allowsCustomAmount();
                @endphp
                <article class="gift-card" data-aos="fade-up">
                    <div class="gift-card__media {{ $imageUrl ? '' : 'gift-card__media--placeholder' }}" @if($imageUrl) style="background-image: url('{{ $imageUrl }}');" @endif>
                        @unless($imageUrl)
                            <span>🎁</span>
                        @endunless
                    </div>
                    <div class="gift-card__body">
                        <h3>{{ $product->title }}</h3>
                        @if($product->description)
                            <p>{{ $product->description }}</p>
                        @endif
                        <form action="{{ route('checkout.store', $product->slug) }}" method="post" class="gift-card__form">
                            @csrf
                            <input type="text" name="honeypot" style="display:none" tabindex="-1" autocomplete="off">
                            <div class="form-group">
                                <label class="form-label" for="gift-name-{{ $product->id }}">Seu nome</label>
                                <input type="text" class="form-input" id="gift-name-{{ $product->id }}" name="name" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="gift-email-{{ $product->id }}">Seu e-mail</label>
                                <input type="email" class="form-input" id="gift-email-{{ $product->id }}" name="email" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="gift-phone-{{ $product->id }}">Telefone (opcional)</label>
                                <input type="text" class="form-input" id="gift-phone-{{ $product->id }}" name="phone" placeholder="(00) 00000-0000">
                            </div>
                            @if($allowsCustom)
                                <div class="form-group">
                                    <label class="form-label" for="custom-amount-{{ $product->id }}">Valor do presente</label>
                                    <input type="number" step="0.01" class="form-input" id="custom-amount-{{ $product->id }}" name="custom_amount" value="{{ number_format(($product->min_cents ?? 5000) / 100, 2, '.', '') }}" min="{{ ($product->min_cents ?? 5000) / 100 }}" @if($product->max_cents) max="{{ $product->max_cents / 100 }}" @endif required>
                                    <small class="text-muted">Mínimo R$ {{ number_format(($product->min_cents ?? 5000) / 100, 2, ',', '.') }} @if($product->max_cents) • Máximo R$ {{ number_format($product->max_cents / 100, 2, ',', '.') }} @endif</small>
                                </div>
                            @else
                                <div class="gift-card__price">R$ {{ number_format($product->price_cents / 100, 2, ',', '.') }}</div>
                            @endif
                            <div class="form-group">
                                <label class="form-label" for="gift-message-{{ $product->id }}">Mensagem (opcional)</label>
                                <textarea class="form-textarea" id="gift-message-{{ $product->id }}" name="message" rows="2" placeholder="Escreva um recado para os noivos"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Presentear</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
