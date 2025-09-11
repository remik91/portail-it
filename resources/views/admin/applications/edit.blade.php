@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Modifier l'application : {{ $application->name }}</h1>
    </div>

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
            <form action="{{ route('admin.applications.update', $application) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom de l'application</label>
                            <input type="text" class="form-control" id="name" name="name" required
                                value="{{ old('name', $application->name) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Catégorie</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $application->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="url" class="form-label">URL d'accès</label>
                    <input type="url" class="form-control" id="url" name="url" required
                        value="{{ old('url', $application->url) }}">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $application->description) }}</textarea>
                </div>

                <div class="row">
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

                <hr>

                <h5>Tags</h5>
                <div class="row">
                    @foreach ($tags as $tag)
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                    id="tag-{{ $tag->id }}" @if (in_array($tag->id, old('tags', $applicationTags))) checked @endif>
                                <label class="form-check-label" for="tag-{{ $tag->id }}">
                                    {{ $tag->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ route('admin.applications.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Section Deeplinks (inchangée) -->
    <div class="mt-5">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Deeplinks</h5>
                <a href="{{ route('admin.applications.deeplinks.create', $application) }}"
                    class="btn btn-success btn-sm"><i class="fas fa-plus me-1"></i> Ajouter un Deeplink</a>
            </div>
            <div class="card-body">
                @if ($application->deeplinks->isNotEmpty())
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>URL</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($application->deeplinks as $deeplink)
                                <tr>
                                    <td>{{ $deeplink->name }}</td>
                                    <td><a href="{{ $deeplink->url }}"
                                            target="_blank">{{ Str::limit($deeplink->url, 50) }}</a></td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.applications.deeplinks.edit', [$application, $deeplink]) }}"
                                            class="btn btn-warning btn-sm">Modifier</a>
                                        <form
                                            action="{{ route('admin.applications.deeplinks.destroy', [$application, $deeplink]) }}"
                                            method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">Aucun deeplink pour cette application.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
