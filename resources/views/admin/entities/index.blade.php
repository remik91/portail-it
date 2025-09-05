@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestion des Entités</h1>
        <a href="{{ route('admin.entities.create') }}" class="btn btn-primary">Ajouter une entité</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($entities as $entity)
                        <tr>
                            <td>{{ $entity->id }}</td>
                            <td>{{ $entity->name }}</td>
                            <td>{{ $entity->description }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.entities.edit', $entity) }}"
                                    class="btn btn-sm btn-warning">Modifier</a>
                                <form action="{{ route('admin.entities.destroy', $entity) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Êtes-vous sûr ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Aucune entité trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $entities->links() }}
        </div>
    </div>
@endsection
