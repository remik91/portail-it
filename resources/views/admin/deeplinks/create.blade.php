@extends('layouts.admin')

@section('content')
    <h1>Ajouter un Deeplink à "{{ $application->name }}"</h1>

    <form action="{{ route('admin.applications.deeplinks.store', $application) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nom du lien</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}"
                placeholder="Ex: Créer un ticket">
        </div>
        <div class="mb-3">
            <label for="url" class="form-label">URL complète</label>
            <input type="url" class="form-control" id="url" name="url" required value="{{ old('url') }}"
                placeholder="https://...">
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('admin.applications.edit', $application) }}" class="btn btn-secondary">Annuler</a>
    </form>
@endsection
