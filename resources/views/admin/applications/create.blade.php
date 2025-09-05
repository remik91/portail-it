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

    <form action="{{ route('admin.applications.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nom de l'application</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
        </div>
        <div class="mb-3">
            <label for="url" class="form-label">URL d'accès</label>
            <input type="url" class="form-control" id="url" name="url" required value="{{ old('url') }}"
                placeholder="https://...">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="category_id" class="form-label">Catégorie</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">Sélectionner une catégorie</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="icon" class="form-label">Icône (Font Awesome)</label>
                <input type="text" class="form-control" id="icon" name="icon" value="{{ old('icon') }}"
                    placeholder="ex: fas fa-server">
                <small class="form-text text-muted">Ex: "fas fa-cogs", "fab fa-gitlab". Laissez vide pour pas
                    d'icône.</small>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('admin.applications.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
@endsection
