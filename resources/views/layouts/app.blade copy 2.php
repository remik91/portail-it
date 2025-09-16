<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-fr-scheme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Portail IT') }}</title>

    <!-- DSFR STYLES -->
    {{-- DSFR CSS 1.14 (dernière version stable au 2025-09) --}}
    <link rel="preconnect" href="https://unpkg.com" crossorigin>

    {{-- Icônes DSFR --}}

    <!-- Permet aux pages d'ajouter des styles spécifiques (comme pour le dashboard) -->
    @stack('styles')

    <!-- NOTE: Les scripts Vite sont conservés pour le JS applicatif (comme Alpine.js) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    
</head>

<body class="fr-mb-12w">
    <div class="fr-skiplinks">
        <nav>
            <a class="fr-link" href="#content">Contenu</a>
            <a class="fr-link" href="#fr-navigation-main">Menu</a>
            <a class="fr-link" href="#fr-footer">Pied de page</a>
        </nav>
    </div>

    <header role="banner" class="fr-header">
        <div class="fr-header__body">
            <div class="fr-container">
                <div class="fr-header__body-row">
                    <div class="fr-header__brand fr-enlarge-link">
                        <div class="fr-header__brand-top">
                            <div class="fr-header__logo">
                                <p class="fr-logo">
                                    Académie
                                    <br>de Créteil
                                </p>
                            </div>
                            <div class="fr-header__navbar">
                                <button class="fr-btn--menu fr-btn" data-fr-opened="false" aria-controls="modal-833"
                                    aria-haspopup="menu" title="Menu">
                                    Menu
                                </button>
                            </div>
                        </div>
                        <div class="fr-header__service">
                            <a href="{{ route('dashboard') }}" title="Accueil - {{ config('app.name', 'Portail IT') }}">
                                <p class="fr-header__service-title">{{ config('app.name', 'Portail IT') }}</p>
                            </a>
                            <p class="fr-header__service-tagline">Direction Régionale Académique des systèmes
                                d’information</p>
                        </div>
                    </div>
                    <div class="fr-header__tools">
                        <div class="fr-header__tools-links">
                            @auth
                                <ul class="fr-btns-group">
                                    <li>
                                        <a class="fr-btn fr-icon-account-circle-line" href="{{ route('profile.edit') }}">
                                            {{ Auth::user()->name }}
                                        </a>
                                    </li>
                                    @if (Auth::user()->is_admin)
                                        <li>
                                            <a class="fr-btn fr-icon-settings-4-line" href="{{ route('admin.dashboard') }}">
                                                Panneau Admin
                                            </a>
                                        </li>
                                    @endif
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a class="fr-btn fr-icon-logout-box-r-line" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                                Déconnexion
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main role="main" id="content">
        <!-- Slot pour le header de la page (titre) -->
        @if (isset($header))
            <div class="fr-container fr-py-5w">
                {{ $header }}
            </div>
        @endif

        <!-- Slot pour le contenu principal de la page -->
        {{ $slot }}
    </main>

    <footer class="fr-footer" role="contentinfo" id="fr-footer">
        <div class="fr-container">
            <div class="fr-footer__body">
                <div class="fr-footer__brand fr-enlarge-link">
                    <a href="/" title="Retour à l’accueil">
                        <p class="fr-logo" title="république française">
                            Académie
                            <br>de Créteil
                        </p>
                    </a>
                </div>
                <div class="fr-footer__content">
                    <p class="fr-footer__content-desc">
                        Le portail des applications de la DSI de l'Académie de Créteil.
                    </p>
                </div>
            </div>
            <div class="fr-footer__bottom">
                <ul class="fr-footer__bottom-list">
                    <li class="fr-footer__bottom-item">
                        <a class="fr-footer__bottom-link" href="#">Accessibilité : non conforme</a>
                    </li>
                    <li class="fr-footer__bottom-item">
                        <a class="fr-footer__bottom-link" href="#">Mentions légales</a>
                    </li>
                </ul>
                <div class="fr-footer__bottom-copy">
                    <p>Sauf mention contraire, tous les contenus de ce site sont sous <a
                            href="https://github.com/etalab/licence-ouverte/blob/master/LO_2.0.md"
                            target="_blank">licence etalab-2.0</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- DSFR SCRIPTS -->
    <script type="module" src="https://unpkg.com/@gouvfr/dsfr@1.10.1/dist/dsfr.module.min.js"></script>
    <script type="text/javascript" nomodule src="https://unpkg.com/@gouvfr/dsfr@1.10.1/dist/dsfr.nomodule.min.js"></script>

    <!-- Permet aux pages d'ajouter des scripts spécifiques -->
    @stack('scripts')
</body>

</html>
