<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Portail des Applications DSI') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <strong>Filtres</strong>
                        </div>
                        <ul class="list-group list-group-flush">
                            <a href="{{ route('dashboard') }}"
                                class="list-group-item list-group-item-action
                      {{ !request('filter') && !request('category') ? 'active' : '' }}">
                                <i class="fas fa-grip-horizontal me-2"></i> Toutes les applications
                            </a>

                            <a href="{{ route('dashboard', ['filter' => 'favorites']) }}"
                                class="list-group-item list-group-item-action
                      {{ request('filter') == 'favorites' ? 'active' : '' }}">
                                <i class="fas fa-star me-2"></i> Mes favoris
                            </a>
                        </ul>
                    </div>

                    <div class="card shadow-sm mt-4">
                        <div class="card-header">
                            <strong>Catégories</strong>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($categories as $category)
                                <a href="{{ route('dashboard', ['category' => $category->id]) }}"
                                    class="list-group-item list-group-item-action
                          {{ request('category') == $category->id ? 'active' : '' }}">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </ul>
                    </div>

                    <!-- NOUVEAU BLOC POUR LES TAGS -->
                    @if ($tags->isNotEmpty())
                        <div class="card shadow-sm mt-4">
                            <div class="card-header">
                                <strong>Tags populaires</strong>
                            </div>
                            <div class="card-body">
                                @foreach ($tags as $tag)
                                    <a href="{{ route('dashboard', ['tag' => $tag->id]) }}"
                                        class="btn btn-sm {{ request('tag') == $tag->id ? 'btn-primary' : 'btn-outline-secondary' }} mb-1">
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-9" x-data="{
                    search: '',
                    applications: {{ $applications->toJson() }},
                    favoriteIds: {{ json_encode($favoriteIds) }},
                
                    toggleFavorite(appId) {
                        // Envoi de la requête au serveur
                        fetch(`/applications/${appId}/toggle-favorite`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                            }
                        }).then(response => response.json()).then(data => {
                            if (data.status === 'success') {
                                // Mise à jour de l'état local sans recharger la page
                                if (this.favoriteIds.includes(appId)) {
                                    this.favoriteIds = this.favoriteIds.filter(id => id !== appId);
                                } else {
                                    this.favoriteIds.push(appId);
                                }
                            }
                        });
                    }
                }">


                    @if ($mostUsedApplications->isNotEmpty())
                        <div class="mb-4">
                            <h5 class="mb-3">🚀 Vos applications les plus utilisées</h5>
                            <div class="row">
                                @foreach ($mostUsedApplications as $app)
                                    <div class="col-12 col-md-4 mb-3">
                                        <a href="{{ route('redirect', $app) }}" target="_blank"
                                            class="text-decoration-none">
                                            <div class="card h-100 text-center shadow-sm">
                                                <div class="card-body p-3">
                                                    <i class="{{ $app->icon }} fa-2x text-primary mb-2"></i>
                                                    <h6 class="card-title mb-0">{{ $app->name }}</h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <hr class="mb-4">
                    @endif

                    <div class="mb-4">
                        <input type="text" class="form-control" placeholder="Rechercher..."
                            x-model.debounce.300ms="search">
                    </div>

                    <div class="overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4 text-gray-900">
                            <div class="row">
                                <template
                                    x-for="app in applications.filter(item => item.name.toLowerCase().includes(search.toLowerCase()) || item.description.toLowerCase().includes(search.toLowerCase()))"
                                    :key="app.id">
                                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                                        <div class="card h-100 text-center shadow-sm position-relative">
                                            <div @click.prevent.stop="toggleFavorite(app.id)"
                                                class="position-absolute top-0 end-0 p-2"
                                                style="cursor: pointer; z-index: 10;" title="Ajouter aux favoris">
                                                <i
                                                    :class="favoriteIds.includes(app.id) ? 'fas fa-star text-warning' :
                                                        'far fa-star'"></i>
                                            </div>

                                            <a :href="`/redirect/${app.id}`" target="_blank"
                                                class="text-decoration-none text-dark d-block h-100">
                                                <div class="card-body d-flex flex-column">
                                                    <div class="flex-grow-1">
                                                        <i :class="app.icon" class="fa-3x text-primary mb-3"></i>
                                                        <h5 class="card-title" x-text="app.name"></h5>
                                                        <p class="card-text small text-muted" x-text="app.description">
                                                        </p>
                                                    </div>
                                                    <div class="mt-auto pt-2">
                                                        <span class="badge bg-secondary"
                                                            x-text="app.category.name"></span>
                                                    </div>
                                                </div>
                                            </a>

                                            <!-- DEEPLINKS DROPDOWN -->
                                            <template x-if="app.deeplinks && app.deeplinks.length > 0">
                                                <div class="card-footer bg-light">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                            type="button" :id="'dropdownMenuButton' + app.id"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            Accès rapides
                                                        </button>
                                                        <ul class="dropdown-menu"
                                                            :aria-labelledby="'dropdownMenuButton' + app.id">
                                                            <template x-for="deeplink in app.deeplinks"
                                                                :key="deeplink.id">
                                                                <li><a class="dropdown-item" :href="deeplink.url"
                                                                        target="_blank" x-text="deeplink.name"></a></li>
                                                            </template>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
