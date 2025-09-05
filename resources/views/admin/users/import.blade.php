@extends('layouts.admin')

@section('content')
    <h1>Importer un utilisateur depuis l'Active Directory</h1>
    <p>Cette action va rechercher un utilisateur par son samaccountname et le créer ou le mettre à jour dans la base de
        données de l'application.</p>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.users.import.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="samaccountname" class="form-label">Samaccountname de l'utilisateur</label>
                    <input type="text" class="form-control" id="samaccountname" name="samaccountname" required
                        value="{{ old('samaccountname') }}" placeholder="Ex: jdupont">
                    <div class="form-text">
                        C'est le nom de connexion Windows (ou login) de l'utilisateur.
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Rechercher et Importer</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
@endsection
