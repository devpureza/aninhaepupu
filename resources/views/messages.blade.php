@extends('layouts.app')

@section('title', 'Mural de Mensagens | Ana & Mateus')

@section('content')
<section class="section">
    <div class="container container-sm text-center">
        <span class="home-story__eyebrow">Carinho por escrito</span>
        <h1 class="section-title">Mural de mensagens</h1>
        <p class="home-intro">
            Deixe aqui seu recado para os noivos. Cada palavra vira combustível para os preparativos e emociona a gente.
        </p>
        @if(session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif
    </div>
</section>

<section class="section section-alt">
    <div class="container container-sm">
        <form action="{{ route('messages.store') }}" method="post" class="guest-form" data-aos="fade-up">
            @csrf
            <input type="text" name="honeypot" style="display:none" tabindex="-1" autocomplete="off">
            <div class="form-group">
                <label for="guest_name" class="form-label">Seu nome</label>
                <input type="text" id="guest_name" name="guest_name" class="form-input @error('guest_name') is-invalid @enderror" value="{{ old('guest_name') }}" required>
                @error('guest_name')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="content" class="form-label">Mensagem</label>
                <textarea id="content" name="content" rows="4" class="form-textarea @error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
                @error('content')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group form-group--inline">
                <label class="form-checkbox">
                    <input type="checkbox" name="is_public" {{ old('is_public', true) ? 'checked' : '' }}> Quero que apareça no mural público
                </label>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Enviar mensagem</button>
        </form>
    </div>
</section>

@if($messages->isNotEmpty())
<section class="section">
    <div class="container">
        <div class="home-messages">
            @foreach($messages as $message)
                <article class="home-message-card" data-aos="fade-up">
                    <div class="home-message-card__header">
                        <span class="home-message-card__icon">💌</span>
                        <div>
                            <p class="home-message-card__author">{{ $message->guest_name }}</p>
                            <p class="home-message-card__date">{{ $message->created_at?->translatedFormat('d \d\e F \d\e Y') }}</p>
                        </div>
                    </div>
                    <p class="home-message-card__content">“{{ $message->content }}”</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
