@extends('layouts.app')

@section('title', 'Pagamento não concluído | Ana & Mateus')

@section('content')
<section class="section">
    <div class="container container-sm text-center">
        <span class="home-story__eyebrow">Ops!</span>
        <h1 class="section-title">Não conseguimos finalizar</h1>
        <p class="home-intro">
            Parece que o pagamento foi cancelado ou não foi concluído. Você pode tentar novamente e, se tiver dúvidas, fale com a gente.
        </p>
        <a href="{{ route('gifts') }}" class="btn btn-primary">Tentar novamente</a>
    </div>
</section>
@endsection
