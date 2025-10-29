@extends('layouts.app')

@section('title', 'Nossa História | Ana & Mateus')

@section('content')
<section class="section section-story">
    <div class="container container-lg">
        <div class="home-story">
            <div class="home-story__media" data-aos="fade-right">
                <div class="home-story__frame">
                    <img src="{{ asset('monograma-am.svg') }}" alt="Monograma Ana & Mateus" loading="lazy">
                </div>
            </div>
            <div class="home-story__content" data-aos="fade-left">
                <span class="home-story__eyebrow">Ana &amp; Mateus</span>
                <h1>Nossa história é feita de momentos simples e inesquecíveis</h1>
                <p>
                    Desde o primeiro café juntos, sabíamos que a conversa não terminaria ali. Cada viagem, refeição improvisada
                    e música compartilhada reforçou o que sentimos: somos melhores quando estamos lado a lado.
                </p>
                <div class="home-story__cta">
                    <a href="{{ route('rsvp') }}" class="btn btn-primary btn-lg">Confirmar presença</a>
                    <a href="{{ route('gifts') }}" class="btn btn-secondary btn-lg">Presentes &amp; cotinhas</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container container-lg">
        <div class="story-grid">
            @foreach($chapters as $index => $chapter)
                <article class="story-card" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <span class="story-card__step">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <h2>{{ $chapter['title'] }}</h2>
                    <h3>{{ $chapter['subtitle'] }}</h3>
                    <p>{{ $chapter['content'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="section section-alt">
    <div class="container">
        <div class="story-highlights">
            <h2 class="section-title text-center">O que nos define</h2>
            <ul class="story-highlights__list">
                @foreach($highlights as $highlight)
                    <li data-aos="zoom-in">{{ $highlight }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
@endsection
