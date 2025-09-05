@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Modifier l'application : <strong>{{ $application->name }}</strong></h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.applications.update', $application) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card shadow-sm">
            <div class="card-header">
                Informations de l'application
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="name" name="name" required
                        value="{{ old('name', $application->name) }}">
                </div>
                <div class="mb-3">
                    <label for="url" class="form-label">URL</label>
                    <input type="url" class="form-control" id="url" name="url" required
                        value="{{ old('url', $application->url) }}">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $application->description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Catégorie</label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if (old('category_id', $application->category_id) == $category->id) selected @endif>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="icon" class="form-label">Icône (ex: fas fa-server)</label>
                    <input type="text" class="form-control" id="icon" name="icon"
                        value="{{ old('icon', $application->icon) }}">
                </div>

                <div class="mb-3">
                    <label for="tags" class="form-label">Tags</label>
                    <select name="tags[]" id="tags" class="form-select" multiple>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}" @if (in_array($tag->id, old('tags', $applicationTags ?? []))) selected @endif>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Maintenez Ctrl (ou Cmd) pour en sélectionner plusieurs.</small>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="{{ route('admin.applications.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>

    @include('admin.applications._deeplinks-list')

@endsection
