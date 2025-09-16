<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
        <style>
            /* --- Styles généraux de la carte --- */
            .app-card {
                display: flex;
                flex-direction: column;
                height: 100%;
                text-align: center;
                transition: transform 0.2s ease-out, box-shadow 0.2s ease-out;
            }

            /* CORRECTION : On utilise :has() pour dissocier les survols */
            .app-card:not(:has(.favorite-btn:hover)):hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            }

            .app-card-body {
                padding: 1rem;
                flex-grow: 1;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .app-card-visual {
                height: 48px;
                width: 48px;
                margin-bottom: 1rem;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2.5rem;
                color: var(--artwork-minor-blue-france);
            }

            .app-card-logo {
                max-height: 100%;
                max-width: 100%;
                object-fit: contain;
            }

            .app-card-content {
                flex-grow: 1;
            }

            .app-card-actions {
                margin-top: auto;
                padding: 0 1rem 1rem 1rem;
            }

            .favorite-btn {
                position: absolute;
                top: 0.5rem;
                right: 0.5rem;
                z-index: 10;
                background-color: transparent;
                border: none;
                padding: 0;
                cursor: pointer;
                height: 32px;
                width: 32px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                transition: background-color 0.2s ease;
            }

            .favorite-btn:hover {
                background-color: rgba(0, 0, 0, 0.05);
            }
        </style>
    @endpush

    <div class="fr-container fr-py-5w">

        <div class="fr-grid-row fr-grid-row--gutters">
            <!-- Colonne de la Barre Latérale -->
            <div class="fr-col-12 fr-col-md-4 fr-col-lg-3">
                <nav class="fr-sidemenu" aria-labelledby="fr-sidemenu-title">
                    <div class="fr-sidemenu__inner">
                        <button class="fr-sidemenu__btn" hidden aria-controls="fr-sidemenu-wrapper"
                            aria-expanded="false">Dans cette rubrique</button>
                        <div class="fr-collapse" id="fr-sidemenu-wrapper">

                            <p class="fr-sidemenu__title">Catégories</p>
                            <ul class="fr-sidemenu__list">
                                <li
                                    class="fr-sidemenu__item {{ !request()->hasAny(['filter', 'category', 'tag']) ? 'fr-sidemenu__item--active' : '' }}">
                                    <a class="fr-sidemenu__link" href="{{ route('dashboard') }}"
                                        @if (!request()->hasAny(['filter', 'category', 'tag'])) aria-current="page" @endif>Toutes les
                                        applications</a>
                                </li>
                                @foreach ($categories as $category)
                                    <li
                                        class="fr-sidemenu__item {{ request('category') == $category->id ? 'fr-sidemenu__item--active' : '' }}">
                                        <a class="fr-sidemenu__link"
                                            href="{{ route('dashboard', ['category' => $category->id]) }}"
                                            @if (request('category') == $category->id) aria-current="page" @endif>{{ $category->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </nav>

                @if ($tags->isNotEmpty())
                    <div class="fr-mt-3w">
                        <p class="fr-h6">Tags</p>
                        <ul class="fr-tags-group">
                            @foreach ($tags as $tag)
                                <li>
                                    <a href="{{ route('dashboard', ['tag' => $tag->id]) }}"
                                        class="fr-tag {{ request('tag') == $tag->id ? 'fr-tag--toggled' : '' }}"
                                        aria-pressed="{{ request('tag') == $tag->id ? 'true' : 'false' }}">{{ $tag->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Colonne Principale pour les Applications -->
            <div class="fr-col-12 fr-col-md-8 fr-col-lg-9" x-data="{
                search: '',
                applications: {{ $applications->toJson() }},
                favoriteIds: {{ json_encode($favoriteIds) }},
            
                toggleFavorite(appId) {
                    fetch(`/applications/${appId}/toggle-favorite`, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content') }
                    }).then(response => response.json()).then(data => {
                        if (data.status === 'success') {
                            if (this.favoriteIds.includes(appId)) {
                                this.favoriteIds = this.favoriteIds.filter(id => id !== appId);
                            } else {
                                this.favoriteIds.push(appId);
                            }
                        }
                    });
                }
            }">
                <!-- SECTION PLUS UTILISÉES -->
                @if (isset($mostUsedApplications) && $mostUsedApplications->isNotEmpty())
                    <h2 class="fr-h4">🚀 Vos applications les plus utilisées</h2>
                    <div class="fr-grid-row fr-grid-row--gutters fr-mb-5w">
                        @foreach ($mostUsedApplications as $app)
                            <div class="fr-col-12 fr-col-md-4">
                                <div class="fr-tile fr-enlarge-link">
                                    <div class="fr-tile__body">
                                        <h3 class="fr-tile__title">
                                            <a href="{{ route('redirect', $app) }}"
                                                target="_blank">{{ $app->name }}</a>
                                        </h3>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Barre de recherche -->
                <div class="fr-search-bar fr-mb-5w" role="search">
                    <input class="fr-input" placeholder="Rechercher" type="search" x-model.debounce.300ms="search">
                    <button class="fr-btn" title="Rechercher">Rechercher</button>
                </div>

                <!-- Grille des applications (NOUVEAU DESIGN VERTICAL) -->
                <div class="fr-grid-row fr-grid-row--gutters">
                    <template
                        x-for="app in applications.filter(item => item.name.toLowerCase().includes(search.toLowerCase()))"
                        :key="app.id">
                        <div class="fr-col-12 fr-col-md-6 fr-col-lg-4">
                            <div class="fr-card app-card fr-enlarge-link">
                                <!-- Bouton favoris réintégré -->
                                <button @click.prevent.stop="toggleFavorite(app.id)" class=" favorite-btn"
                                    :title="favoriteIds.includes(app.id) ? 'Retirer des favoris' : 'Ajouter aux favoris'">
                                    <i :class="favoriteIds.includes(app.id) ? 'fr-icon-star-fill' : 'fr-icon-star-line'"
                                        :style="favoriteIds.includes(app.id) ? { color: 'var(--warning-425)' } : {}"></i>
                                </button>

                                <div class="app-card-body">
                                    <div class="app-card-visual">
                                        <template x-if="app.logo_path">
                                            <img :src="`/storage/${app.logo_path}`" :alt="`Logo de ${app.name}`"
                                                class="app-card-logo">
                                        </template>
                                        <template x-if="!app.logo_path">
                                            <i :class="app.icon"></i>
                                        </template>
                                    </div>
                                    <div class="app-card-content">
                                        <h4 class="fr-card__title ">
                                            <a :href="`/redirect/${app.id}`" target="_blank" x-text="app.name"
                                                class="fr-card__link"></a>
                                        </h4>
                                        <p class="fr-card__desc" x-text="app.description"></p>
                                        <ul class="fr-tags-group fr-mt-1w">
                                            <template x-for="tag in app.tags" :key="tag.id">
                                                <li>
                                                    <p class="fr-tag fr-tag--sm" x-text="tag.name"></p>
                                                </li>
                                            </template>
                                        </ul>
                                        <div class="app-card-actions fr-mt-1w">
                                            <div
                                                class="fr-btns-group fr-btns-group--sm fr-btns-group--inline-sm fr-btns-group--center">
                                                <template x-for="link in app.deeplinks" :key="link.id">
                                                    <li><a class="fr-btn fr-btn--secondary" :href="link.url"
                                                            target="_blank" x-text="link.name"></a></li>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </template>
                </div>

                <!-- Message si aucun résultat -->
                <div x-show="!applications.filter(item => item.name.toLowerCase().includes(search.toLowerCase())).length"
                    class="fr-callout fr-mt-5w">
                    <p class="fr-callout__title">Aucun résultat</p>
                    <p class="fr-callout__text">Aucune application ne correspond à votre sélection.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
