@extends('layouts.app')

@section('title', 'Pagamento pendente | Ana & Mateus')

@section('content')
<section class="section">
    <div class="container container-sm text-center">
        <span class="home-story__eyebrow">Almost there</span>
        <h1 class="section-title">Pagamento em análise</h1>
        <p class="home-intro">
            O Mercado Pago ainda está processando o pagamento. Assim que for confirmado, enviaremos um e-mail com os detalhes.
        </p>
        <a href="{{ route('home') }}" class="btn btn-secondary">Voltar para a página inicial</a>
    </div>
</section>
@endsection
