{{-- =====================================================================
|  app.blade.php (x-app-layout unique avec dashboard inclus)
|====================================================================== --}}
@props(['title' => config('app.name', 'Portail IT'), 'breadcrumbs' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-fr-scheme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <link rel="preconnect" href="https://unpkg.com" crossorigin>
    <link rel="stylesheet" href="https://unpkg.com/@gouvfr/dsfr@1.14.0/dist/dsfr.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@gouvfr/dsfr@1.14.0/dist/utility/icons/icons.min.css">

    @stack('styles')

    <style>
        .app-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main[role="main"] {
            flex: 1;
        }

        @media (max-width: 48em) {
            .layout-with-aside {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
</head>

<body class="app-container">
    <a class="fr-skiplink" href="#contenu">Aller au contenu</a>

    {{-- HEADER --}}
    <header role="banner" class="fr-header" aria-label="En-tête">
        <div class="fr-header__body">
            <div class="fr-container">
                <div class="fr-header__body-row">
                    <div class="fr-header__brand fr-enlarge-link">
                        <div class="fr-header__brand-top">
                            <div class="fr-header__logo">
                                <p class="fr-logo">République<br>Française</p>
                            </div>
                            <div class="fr-header__navbar"><button class="fr-btn--menu fr-btn" data-fr-opened="false"
                                    aria-controls="modal-menu" aria-haspopup="menu">Menu</button></div>
                        </div>
                        <div class="fr-header__service">
                            <a href="">
                                <p class="fr-header__service-title">{{ config('app.name', 'Portail IT') }}</p>
                            </a>
                            <p class="fr-header__service-tagline">Annuaire d’applications</p>
                        </div>
                    </div>
                    <div class="fr-header__tools">
                        <div class="fr-header__tools-links">
                            <button class="fr-btn fr-icon-theme-fill fr-btn--icon-left" id="theme-toggle"
                                type="button">Thème</button>
                        </div>
                        <div class="fr-connect-group">
                            @auth
                                <button class="fr-connect fr-connect--account fr-btn" aria-controls="account-menu"
                                    aria-expanded="false">
                                    <span class="fr-connect__name">{{ Auth::user()->name }}</span>
                                    <span class="fr-connect__login">{{ Auth::user()->email }}</span>
                                </button>
                                <div class="fr-collapse fr-menu" id="account-menu" role="menu">
                                    <div class="fr-container fr-py-2w">
                                        <ul class="fr-menu__list">
                                            <li><a class="fr-menu__link" href="">Mon profil</a>
                                            </li>
                                            <li><a class="fr-menu__link" href="">Mes
                                                    favoris</a></li>
                                            <li><a class="fr-menu__link" href="">Préférences</a></li>
                                            <li role="separator" class="fr-hr"></li>
                                            <li>
                                                <form method="POST" action="{{ route('logout') }}">@csrf<button
                                                        class="fr-btn fr-btn--secondary" type="submit">Se
                                                        déconnecter</button></form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @else
                                <a class="fr-btn" href="{{ route('login') }}">Se connecter</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fr-header__menu fr-modal" id="modal-menu">
            <div class="fr-container">
                <button class="fr-link--close fr-link" aria-controls="modal-menu">Fermer</button>
                <nav class="fr-nav" role="navigation">
                    <ul class="fr-nav__list">
                        <li><a class="fr-nav__link" href="">Accueil</a></li>
                        <li><a class="fr-nav__link" href="{{ route('dashboard') }}">Applications</a></li>
                        <li><a class="fr-nav__link" href="">Catégories</a></li>

                    </ul>
                </nav>
            </div>
        </div>
    </header>

    @isset($breadcrumbs)
        <div class="fr-breadcrumb">
            <div class="fr-container">{!! $breadcrumbs !!}</div>
        </div>
    @endisset

    <main id="contenu" role="main" class="fr-container fr-pt-4w fr-pb-6w">
        {{ $slot }}
    </main>

    {{-- FOOTER --}}
    <footer class="fr-footer" role="contentinfo">
        <div class="fr-container">
            <div class="fr-footer__body">
                <div class="fr-footer__brand fr-enlarge-link">
                    <p class="fr-logo">République<br>Française</p>
                    <a class="fr-footer__brand-link" href="">{{ config('app.name', 'Portail IT') }}</a>
                </div>
                <div class="fr-footer__content">
                    <ul class="fr-footer__content-list">
                        <li><a href="">Mentions légales</a></li>
                        <li><a href="">Accessibilité</a></li>
                        <li><a href="">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script type="module" src="https://unpkg.com/@gouvfr/dsfr@1.14.0/dist/dsfr.module.min.js"></script>
    <script nomodule src="https://unpkg.com/@gouvfr/dsfr@1.14.0/dist/dsfr.nomodule.min.js"></script>
    <script>
        (function() {
            const root = document.documentElement;
            const btn = document.getElementById('theme-toggle');
            const key = 'dsfr-scheme';

            function apply(s) {
                root.setAttribute('data-fr-scheme', s);
            }
            const saved = localStorage.getItem(key);
            if (saved) apply(saved);
            if (btn) {
                btn.addEventListener('click', () => {
                    const current = root.getAttribute('data-fr-scheme') || 'light';
                    const next = current === 'light' ? 'dark' : 'light';
                    apply(next);
                    localStorage.setItem(key, next);
                });
            }
        })();
    </script>
</body>

</html>
