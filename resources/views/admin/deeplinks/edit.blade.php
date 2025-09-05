@extends('layouts.admin')

@section('content')
    <h1>Modifier le Deeplink pour "{{ $application->name }}"</h1>

    <form action="{{ route('admin.applications.deeplinks.update', [$application, $deeplink]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nom du lien</label>
            <input type="text" class="form-control" id="name" name="name" required
                value="{{ old('name', $deeplink->name) }}">
        </div>
        <div class="mb-3">
            <label for="url" class="form-label">URL complète</label>
            <input type="url" class="form-control" id="url" name="url" required
                value="{{ old('url', $deeplink->url) }}">
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('admin.applications.edit', $application) }}" class="btn btn-secondary">Annuler</a>
    </form>
@endsection
