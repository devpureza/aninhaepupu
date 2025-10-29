<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Ana & Mateus | Casamento')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body>
    <!-- Header/Navigation -->
    <header class="header">
        <nav class="container">
            <div class="nav-wrapper">
                <a href="{{ route('home') }}" class="logo">
                    <span class="monogram">A & M</span>
                </a>
                
                <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <ul class="nav-menu" id="navMenu">
                    <li><a href="{{ route('home') }}" @class(['active' => request()->routeIs('home')])>Início</a></li>
                    <li><a href="{{ route('story') }}" @class(['active' => request()->routeIs('story')])>Nossa História</a></li>
                    <li><a href="{{ route('schedule') }}" @class(['active' => request()->routeIs('schedule')])>Cronograma</a></li>
                    <li><a href="{{ route('location') }}" @class(['active' => request()->routeIs('location')])>Local</a></li>
                    <li><a href="{{ route('rsvp') }}" @class(['active' => request()->routeIs('rsvp')])>RSVP</a></li>
                    <li><a href="{{ route('gifts') }}" @class(['nav-highlight', 'active' => request()->routeIs('gifts')])>Presentes</a></li>
                    <li><a href="{{ route('messages') }}" @class(['active' => request()->routeIs('messages')])>Mensagens</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3 class="footer-title">Ana & Mateus</h3>
                    <p class="footer-text">{{ config('app.event_date') ? \Carbon\Carbon::parse(config('app.event_date'))->translatedFormat('d \\d\\e F \\d\\e Y') : '20 de Dezembro de 2025' }}</p>
                    <p class="footer-text">{{ env('EVENT_VENUE', 'Espaço Villa Borghese') }}</p>
                </div>

                <div class="footer-section">
                    <h4 class="footer-title">Contato</h4>
                    <p class="footer-text">
                        <a href="mailto:{{ config('mail.from.address') }}">{{ config('mail.from.address') }}</a>
                    </p>
                </div>

                <div class="footer-section">
                    <h4 class="footer-title">Links</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('faq') }}">FAQ</a></li>
                        <li><a href="{{ route('privacy') }}">Privacidade</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Ana & Mateus. Feito com ❤️ por Mateus Pureza.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
