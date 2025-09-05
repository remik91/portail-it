 <!-- Section Deeplinks -->
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-link me-2"></i>Deeplinks (Accès Rapides)</h5>
            <a href="{{ route('admin.applications.deeplinks.create', $application) }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus me-1"></i> Ajouter un Deeplink
            </a>
        </div>
        <div class="card-body">
            @if ($application->deeplinks->isEmpty())
                <p class="text-muted text-center my-3">Cette application n'a pas encore de deeplinks.</p>
            @else
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>URL</th>
                            <th class="text-end" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($application->deeplinks as $deeplink)
                            <tr>
                                <td>{{ $deeplink->name }}</td>
                                <td><a href="{{ $deeplink->url }}"
                                        target="_blank">{{ Str::limit($deeplink->url, 50) }}</a></td>
                                <td class="text-end">
                                    <a href="{{ route('admin.applications.deeplinks.edit', [$application, $deeplink]) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form
                                        action="{{ route('admin.applications.deeplinks.destroy', [$application, $deeplink]) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce deeplink ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>