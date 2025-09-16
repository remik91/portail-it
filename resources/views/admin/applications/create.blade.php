@extends('layouts.admin')

@section('content')
    <h1>Ajouter une nouvelle application</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.applications.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom de l'application</label>
                            <input type="text" class="form-control" id="name" name="name" required
                                value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Catégorie</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="url" class="form-label">URL d'accès</label>
                    <input type="url" class="form-control" id="url" name="url" required
                        value="{{ old('url') }}" placeholder="https://...">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                </div>



                <hr>

                <h5>Tags</h5>
                <div class="row">
                    @foreach ($tags as $tag)
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                    id="tag-{{ $tag->id }}">
                                <label class="form-check-label" for="tag-{{ $tag->id }}">
                                    {{ $tag->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <h5 class="mt-4">Visuel</h5>
                <p class="text-muted">Choisissez un logo (prioritaire) ou une icône.</p>

                <div class="row">
                    <!-- Champ Logo -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo Personnalisé (PNG, JPG, SVG...)</label>
                            <input class="form-control" type="file" id="logo" name="logo">
                        </div>
                        @if ($application->logo_path)
                            <div class="mb-3">
                                <p>Logo actuel :</p>
                                <img src="{{ asset('storage/' . $application->logo_path) }}"
                                    alt="Logo de {{ $application->name }}" style="max-height: 80px; border-radius: 8px;">
                            </div>
                        @endif
                    </div>

                    <!-- Champ Icône -->
                    <div class="col-md-6">
                        <div class="mb-3" x-data="{ selectedIcon: '{{ old('icon', $application->icon ?? '') }}' }">
                            <label for="icon" class="form-label">Icône</label>
                            <div class="input-group">
                                <span class="input-group-text" style="width: 4rem; justify-content: center;">
                                    <i
                                        class="fa-2x {{ $application->icon ? $application->icon : 'fas fa-question-circle' }}"></i>
                                </span>
                                <select class="form-select" id="icon" name="icon" x-model="selectedIcon">
                                    <option value="">-- Aucune icône --</option>
                                    @foreach ($icons as $class => $name)
                                        <option value="{{ $class }}"
                                            {{ old('icon', $application->icon) == $class ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="{{ route('admin.applications.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@endsection
