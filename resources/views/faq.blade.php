@extends('layouts.app')

@section('title', 'Perguntas frequentes | Ana & Mateus')

@section('content')
<section class="section">
    <div class="container container-sm text-center">
        <span class="home-story__eyebrow">Tudo que você precisa saber</span>
        <h1 class="section-title">Perguntas frequentes</h1>
        <p class="home-intro">
            Selecionamos algumas respostas para facilitar o planejamento. Se ainda tiver dúvidas, fale com a gente
            pelos contatos no rodapé.
        </p>
    </div>
</section>

<section class="section section-alt">
    <div class="container container-sm">
        <div class="faq-list">
            @foreach($faqs as $index => $faq)
                <article class="faq-item" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <h2>{{ $faq['question'] }}</h2>
                    <p>{{ $faq['answer'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
