@extends('layouts.app')

@section('title', 'Como chegar | Ana & Mateus')

@section('content')
<section class="section">
    <div class="container container-sm text-center">
        <span class="home-story__eyebrow">Nos encontramos aqui</span>
        <h1 class="section-title">{{ $venue['name'] }}</h1>
        <p class="home-intro">{{ $venue['address'] }}</p>
    </div>
</section>

<section class="section section-alt">
    <div class="container">
        <div class="location-map" data-aos="fade-up">
            <iframe src="{{ $venue['map_url'] }}" width="100%" height="420" style="border:0;" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="location-cards">
            <article class="location-card" data-aos="fade-up" data-aos-delay="100">
                <h3>Estacionamento</h3>
                <p>{{ $venue['parking'] }}</p>
            </article>
            <article class="location-card" data-aos="fade-up" data-aos-delay="200">
                <h3>Hospedagem sugerida</h3>
                <ul>
                    @foreach($venue['hotels'] as $hotel)
                        <li>
                            <strong>{{ $hotel['name'] }}</strong>
                            <span>{{ $hotel['description'] }}</span>
                            @if(!empty($hotel['link']))
                                <a href="{{ $hotel['link'] }}" target="_blank" rel="noopener">Site oficial</a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </article>
        </div>
    </div>
</section>

<section class="section">
    <div class="container container-sm">
        <h2 class="section-title text-center">Dicas de deslocamento</h2>
        <ul class="tips-list">
            @foreach($transportation as $tip)
                <li data-aos="fade-up">{{ $tip }}</li>
            @endforeach
        </ul>
    </div>
</section>
@endsection
