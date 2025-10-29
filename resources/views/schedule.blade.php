@extends('layouts.app')

@section('title', 'Cronograma do Grande Dia | Ana & Mateus')

@section('content')
<section class="section">
    <div class="container container-sm text-center">
        <span class="home-story__eyebrow">Save the date</span>
        <h1 class="section-title">Cronograma do grande dia</h1>
        <p class="home-intro">
            Planejamos cada momento com carinho para que você aproveite intensamente.
            Chegue com antecedência, prepare a câmera e venha celebrar com a gente!
        </p>
    </div>
</section>

<section class="section section-alt">
    <div class="container container-lg">
        <div class="timeline">
            @foreach($timeline as $index => $item)
                <div class="timeline__item" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="timeline__time">{{ $item['time'] }}</div>
                    <div class="timeline__content">
                        <h3>{{ $item['title'] }}</h3>
                        <p>{{ $item['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section">
    <div class="container container-sm">
        <h2 class="section-title text-center">Dicas importantes</h2>
        <ul class="tips-list">
            @foreach($tips as $tip)
                <li data-aos="fade-up">{{ $tip }}</li>
            @endforeach
        </ul>
    </div>
</section>
@endsection
