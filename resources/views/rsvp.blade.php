@extends('layouts.app')

@section('title', 'Confirme sua Presença | Ana & Mateus')

@section('content')
<section class="section section-rsvp">
    <div class="container container-sm">
        <div class="home-rsvp" data-aos="zoom-in">
            <span class="home-rsvp__eyebrow">Estamos contando com você</span>
            <h1>Confirme sua presença</h1>
            <p>
                Preencha o formulário abaixo para nos avisar se você virá e se trará acompanhantes. Assim podemos
                preparar tudo com carinho e cuidado especial.
            </p>
            @if(session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif
            <form action="{{ route('rsvp.store') }}" method="post" class="guest-form" id="rsvpForm">
                @csrf
                <input type="text" name="honeypot" style="display:none" tabindex="-1" autocomplete="off">
                <div class="form-group">
                    <label for="name" class="form-label">Nome completo</label>
                    <input type="text" id="name" name="name" class="form-input @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" id="email" name="email" class="form-input @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone" class="form-label">Telefone (opcional)</label>
                    <input type="text" id="phone" name="phone" class="form-input @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="(11) 99999-9999">
                    @error('phone')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Você poderá estar presente?</label>
                    <div class="form-group--inline">
                        <label class="form-checkbox">
                            <input type="radio" name="attending" value="1" {{ old('attending', '1') === '1' ? 'checked' : '' }}> Sim, com certeza!
                        </label>
                        <label class="form-checkbox">
                            <input type="radio" name="attending" value="0" {{ old('attending') === '0' ? 'checked' : '' }}> Infelizmente não poderei ir
                        </label>
                    </div>
                    @error('attending')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group" id="companionsGroup">
                    <label for="companions" class="form-label">Quantas pessoas vêm com você?</label>
                    <input type="number" id="companions" name="companions" min="0" max="10" class="form-input @error('companions') is-invalid @enderror" value="{{ old('companions', 0) }}">
                    <small class="text-muted">Conte apenas acompanhantes extras — nós já contamos você! :)</small>
                    @error('companions')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="dietary_notes" class="form-label">Alguma observação? (restrição alimentar, recado etc.)</label>
                    <textarea id="dietary_notes" name="dietary_notes" rows="3" class="form-textarea @error('dietary_notes') is-invalid @enderror">{{ old('dietary_notes') }}</textarea>
                    @error('dietary_notes')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-lg">Enviar confirmação</button>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const attendingInputs = document.querySelectorAll('input[name="attending"]');
        const companionsGroup = document.getElementById('companionsGroup');

        function toggleCompanions() {
            const value = document.querySelector('input[name="attending"]:checked').value;
            companionsGroup.style.display = value === '1' ? 'block' : 'none';
        }

        attendingInputs.forEach((input) => input.addEventListener('change', toggleCompanions));
        toggleCompanions();
    });
</script>
@endpush
