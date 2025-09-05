@extends('layouts.admin')

@section('content')
    <h1>Gérer l'utilisateur : {{ $user->name }}</h1>
    <p class="text-muted">Utilisateur AD : {{ $user->samaccountname }}</p>

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Colonne Informations & Permissions -->
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        Informations & Permissions
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="name" name="name" required
                                value="{{ old('name', $user->name) }}">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required
                                value="{{ old('email', $user->email) }}">
                        </div>
                        <hr>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_admin" name="is_admin"
                                @if (old('is_admin', $user->is_admin)) checked @endif>
                            <label class="form-check-label" for="is_admin">Est Administrateur</label>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header">
                        Appartenance aux entités
                    </div>
                    <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                        @foreach ($entities as $entity)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="entities[]"
                                    value="{{ $entity->id }}" id="entity{{ $entity->id }}"
                                    @if (in_array($entity->id, old('entities', $userEntityIds))) checked @endif>
                                <label class="form-check-label" for="entity{{ $entity->id }}">
                                    {{ $entity->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Colonne Applications Directes -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        Accès directs aux applications
                    </div>
                    <div class="card-body" style="max-height: 500px; overflow-y: auto;">
                        @foreach ($applications as $application)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="applications[]"
                                    value="{{ $application->id }}" id="application{{ $application->id }}"
                                    @if (in_array($application->id, old('applications', $userApplicationIds))) checked @endif>
                                <label class="form-check-label" for="application{{ $application->id }}">
                                    {{ $application->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
@endsection
