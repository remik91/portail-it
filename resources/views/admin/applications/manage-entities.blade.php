@extends('layouts.admin')

@section('content')
    <h1>Gérer les entités pour : <strong>{{ $application->name }}</strong></h1>
    <p>Cochez les entités qui doivent avoir accès à cette application.</p>

    <form action="{{ route('admin.applications.manageEntities.update', $application) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            @foreach ($entities as $entity)
                <div class="col-md-4">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" name="entities[]"
                            value="{{ $entity->id }}" id="entity-{{ $entity->id }}"
                            @if (in_array($entity->id, $linkedEntityIds)) checked @endif>
                        <label class="form-check-label" for="entity-{{ $entity->id }}">
                            {{ $entity->name }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            <a href="{{ route('admin.applications.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
@endsection
