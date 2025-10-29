@extends('layouts.app')

@section('title', 'Ana & Mateus | Nosso Casamento')

@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    \Carbon\Carbon::setLocale('pt_BR');
    setlocale(LC_TIME, 'pt_BR.utf8', 'pt_BR', 'portuguese');

    $eventDate = \Carbon\Carbon::parse(env('EVENT_DATE', '2026-05-16 16:30:00'));
    $eventVenue = env('EVENT_VENUE', 'Espaço Villa Borghese');
    $countdownIso = $eventDate->format('c');
@endphp

@section('content')
<section class="hero">
    <div class="hero-content">
        <h1 class="hero-monogram">A & M</h1>
        <p class="hero-date">{{ $eventDate->translatedFormat('d \\d\\e F \\d\\e Y • H:i') }}</p>
        <p class="hero-venue">{{ $eventVenue }}</p>

        <div class="hero-countdown" id="countdown" data-event-date="{{ $countdownIso }}">
            <!-- Countdown preenchido via JavaScript -->
        </div>
        
        <div class="hero-cta">
            <a href="{{ route('rsvp') }}" class="btn btn-primary btn-lg">Confirmar Presença</a>
            <a href="{{ route('gifts') }}" class="btn btn-amber btn-lg">Ver Presentes</a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container container-sm">
        <h2 class="section-title text-center">Bem-vindos!</h2>
        <div class="text-center">
            <p class="text-lg home-intro">
                É com muita alegria que convidamos você para celebrar conosco este momento tão especial.
                Preparamos este site para compartilhar todos os detalhes do nosso grande dia e facilitar a sua participação
                nessa celebração cheia de amor.
            </p>
        </div>
    </div>
</section>

@php
    $timeline = [
        [
            'date' => 'Agosto · 2016',
            'title' => 'O primeiro encontro',
            'description' => 'Um café despretensioso que virou horas de conversa e a certeza de que algo especial estava começando.',
        ],
        [
            'date' => 'Julho · 2018',
            'title' => 'A viagem inesquecível',
            'description' => 'Descobrimos o prazer de explorar o mundo juntos — e que somos a melhor companhia um do outro.',
        ],
        [
            'date' => 'Setembro · 2023',
            'title' => 'O pedido',
            'description' => 'Em meio a luzes e declarações, trocamos promessas e um “sim” cheio de emoção.',
        ],
        [
            'date' => 'Maio · 2026',
            'title' => 'Vamos dizer SIM',
            'description' => 'Agora, convidamos você para testemunhar e celebrar o início da nossa vida como família.',
        ],
    ];
@endphp

<section class="section section-story">
    <div class="container container-lg">
        <div class="home-story">
            <div class="home-story__media" data-aos="fade-right">
                <div class="home-story__frame">
                    <img src="{{ asset('monograma-am.svg') }}" alt="Monograma A&M" loading="lazy">
                </div>
            </div>
            <div class="home-story__content" data-aos="fade-left">
                <span class="home-story__eyebrow">Ana &amp; Mateus</span>
                <h2>Um amor que floresce com o tempo</h2>
                <p>
                    Nossos caminhos se cruzaram por acaso, mas permaneceram juntos por escolha. Cada capítulo — encontros, viagens, surpresas e planos — nos trouxe até aqui. Agora, queremos dividir esse momento com quem fez parte da construção da nossa história.
                </p>
                <div class="home-story__cta">
                    <a href="{{ route('rsvp') }}" class="btn btn-primary btn-lg">Confirmar presença</a>
                    <a href="{{ route('story') }}" class="btn btn-secondary btn-lg">Nossa história completa</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container container-lg">
        <h2 class="section-title text-center">Linha do tempo do nosso amor</h2>
        <div class="home-timeline">
            @foreach($timeline as $index => $item)
                <article class="home-timeline__item" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="home-timeline__date">{{ $item['date'] }}</div>
                    <h3 class="home-timeline__title">{{ $item['title'] }}</h3>
                    <p class="home-timeline__description">{{ $item['description'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

@if($topProducts->isNotEmpty())
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <div>
                <h2 class="section-title">Top cotas do momento</h2>
                <p class="section-subtitle">Escolhas queridas pelos nossos convidados — escolha a sua e faça parte da nossa história.</p>
            </div>
            <a href="{{ route('gifts') }}" class="btn btn-secondary btn-sm">Ver lista completa</a>
        </div>
        <div class="home-products">
            @foreach($topProducts as $product)
                @php
                    $imageUrl = null;
                    if ($product->cover_image) {
                        $imageUrl = Str::startsWith($product->cover_image, ['http://', 'https://'])
                            ? $product->cover_image
                            : Storage::disk('public')->url($product->cover_image);
                    }
                @endphp
                <article class="home-product-card">
                    <div class="home-product-card__media {{ $imageUrl ? '' : 'home-product-card__media--placeholder' }}" @if($imageUrl) style="background-image: url('{{ $imageUrl }}');" @endif>
                        @unless($imageUrl)
                            <span class="home-product-card__media-icon">🎁</span>
                        @endunless
                    </div>
                    <div class="home-product-card__body">
                        <h3>{{ $product->title }}</h3>
                        @if($product->description)
                            <p>{{ $product->description }}</p>
                        @endif
                        <div class="home-product-card__footer">
                            <span class="home-product-card__price">R$ {{ number_format($product->price_cents / 100, 2, ',', '.') }}</span>
                            <a href="{{ route('gifts') }}#{{ $product->slug ?? 'presentes' }}" class="btn btn-primary btn-sm">Contribuir</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($latestMessages->isNotEmpty())
<section class="section">
    <div class="container">
        <div class="section-header">
            <div>
                <h2 class="section-title">Recados cheios de carinho</h2>
                <p class="section-subtitle">Mensagens que aquecem o coração e nos lembram o quanto somos amados.</p>
            </div>
            <a href="{{ route('messages') }}" class="btn btn-secondary btn-sm">Ver mural completo</a>
        </div>
        <div class="home-messages">
            @foreach($latestMessages as $message)
                <article class="home-message-card">
                    <div class="home-message-card__header">
                        <span class="home-message-card__icon">💌</span>
                        <div>
                            <p class="home-message-card__author">{{ $message->guest_name }}</p>
                            <p class="home-message-card__date">{{ $message->created_at?->translatedFormat('d \\d\\e F \\d\\e Y') }}</p>
                        </div>
                    </div>
                    <p class="home-message-card__content">“{{ $message->content }}”</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="section section-alt">
    <div class="container">
        <div class="home-actions">
            <div class="card home-actions__card">
                <h3 class="card-title">Nossa História</h3>
                <p class="card-body">Conheça nossa jornada — desde o primeiro encontro até o “sim” que mudou tudo.</p>
                <a href="{{ route('story') }}" class="btn btn-secondary">Ler mais</a>
            </div>
            <div class="card home-actions__card">
                <h3 class="card-title">Cronograma</h3>
                <p class="card-body">Veja os horários e os momentos especiais do grande dia para programar sua presença.</p>
                <a href="{{ route('schedule') }}" class="btn btn-secondary">Ver detalhes</a>
            </div>
            <div class="card home-actions__card">
                <h3 class="card-title">Como chegar</h3>
                <p class="card-body">Informações de endereço, mapa e dicas para chegar com tranquilidade à celebração.</p>
                <a href="{{ route('location') }}" class="btn btn-secondary">Planejar trajeto</a>
            </div>
        </div>
    </div>
</section>

<section class="section section-rsvp">
    <div class="container container-sm">
        <div class="home-rsvp" data-aos="zoom-in">
            <span class="home-rsvp__eyebrow">Estamos contando os dias!</span>
            <h2>Reserve seu lugar na nossa festa de amor</h2>
            <p>
                Sua presença é essencial para tornar o nosso “sim” ainda mais especial. Confirme a participação, conte quantos vêm com você e deixe um recadinho — vamos preparar tudo com carinho.
            </p>
            <div class="home-rsvp__actions">
                <a href="{{ route('rsvp') }}" class="btn btn-primary btn-lg">Confirmar presença</a>
                <a href="{{ route('messages') }}" class="btn btn-secondary btn-lg">Deixar um recado</a>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container container-sm text-center">
        <h2 class="section-title">Presentes & Cotinhas</h2>
        <p class="text-lg home-intro">
            Sua presença já é o maior presente, mas se quiser contribuir com um momento especial da nossa lua de mel,
            ficaremos eternamente gratos. Cada gesto, grande ou pequeno, ajuda a tornar esse sonho ainda mais mágico.
        </p>
        <a href="{{ route('gifts') }}" class="btn btn-amber btn-lg">Ver Lista de Presentes</a>
    </div>
</section>
@endsection
