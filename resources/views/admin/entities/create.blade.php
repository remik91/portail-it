@extends('layouts.admin')

@section('content')
    <h1>Ajouter une nouvelle entité</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.entities.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nom de l'entité</label>
                    <input type="text" class="form-control" id="name" name="name" required
                        value="{{ old('name') }}">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('admin.entities.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
@endsection
