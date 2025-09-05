@extends('layouts.admin')

@section('content')
    <h1>Modifier l'entité : {{ $entity->name }}</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.entities.update', $entity) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nom de l'entité</label>
                    <input type="text" class="form-control" id="name" name="name" required
                        value="{{ old('name', $entity->name) }}">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description">{{ old('description', $entity->description) }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('admin.entities.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
@endsection
