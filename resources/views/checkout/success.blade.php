@extends('layouts.app')

@section('title', 'Obrigado pelo presente! | Ana & Mateus')

@section('content')
<section class="section">
    <div class="container container-sm text-center">
        <span class="home-story__eyebrow">Presente confirmado</span>
        <h1 class="section-title">Muito obrigado!</h1>
        <p class="home-intro">
            Recebemos o seu presente com todo carinho. Assim que o pagamento for confirmado pelo Mercado Pago, você receberá um e-mail.
        </p>
        <div class="card" style="margin-top: var(--spacing-2xl);">
            <h2 class="card-title">Resumo</h2>
            <p class="card-body">
                Código do pedido: <strong>{{ $order->code }}</strong><br>
                Valor total: <strong>{{ $order->formatted_total }}</strong>
            </p>
            <a href="{{ route('home') }}" class="btn btn-primary">Voltar para a página inicial</a>
        </div>
    </div>
</section>
@endsection
