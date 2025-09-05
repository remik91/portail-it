@extends('layouts.admin')

@section('content')
    <h1>Ajouter un nouveau tag</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.tags.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nom du Tag</label>
                    <input type="text" class="form-control" id="name" name="name" required
                        value="{{ old('name') }}">
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
@endsection
