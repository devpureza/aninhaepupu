@extends('layouts.app')

@section('title', 'Política de privacidade | Ana & Mateus')

@section('content')
<section class="section">
    <div class="container container-sm text-center">
        <span class="home-story__eyebrow">Respeito aos convidados</span>
        <h1 class="section-title">Política de privacidade</h1>
        <p class="home-intro">
            Este espaço foi criado para celebrar o nosso casamento com segurança e transparência. Entenda como cuidamos
            das informações compartilhadas conosco.
        </p>
    </div>
</section>

<section class="section section-alt">
    <div class="container container-sm">
        <div class="privacy-list">
            @foreach($sections as $index => $section)
                <article class="privacy-item" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <h2>{{ $section['title'] }}</h2>
                    <p>{{ $section['content'] }}</p>
                </article>
            @endforeach
        </div>
        <p class="privacy-note">
            Em caso de dúvidas ou solicitações, escreva para <a href="mailto:{{ config('mail.from.address') }}">{{ config('mail.from.address') }}</a>.
            Estamos à disposição para ajudá-lo.
        </p>
    </div>
</section>
@endsection
