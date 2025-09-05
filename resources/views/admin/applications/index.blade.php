@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestion des Applications</h1>
        <a href="{{ route('admin.applications.create') }}" class="btn btn-primary">Ajouter une application</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $application)
                <tr>
                    <td>{{ $application->id }}</td>
                    <td>{{ $application->name }}</td>
                    <td>{{ $application->description }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.applications.manageEntities.show', $application) }}"
                            class="btn btn-sm btn-info">Gérer Entités</a>
                        <a href="{{ route('admin.applications.edit', $application) }}"
                            class="btn btn-sm btn-warning">Modifier</a>
                        <form action="{{ route('admin.applications.destroy', $application) }}" method="POST"
                            class="d-inline" onsubmit="return confirm('Êtes-vous sûr ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Aucune application trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">
        {{ $applications->links() }}
    </div>
@endsection
