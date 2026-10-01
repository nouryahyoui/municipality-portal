@extends('layouts.admin')

@section('page-title', __('messages.Officials'))
@section('title', __('messages.Officials'))

@section('content')
<div class="page-header">
    <h1>{{ __('messages.Officials') }}</h1>
    <p class="text-muted">Gérer les officiels municipaux</p>
</div>

<div class="card mb-3">
    <div class="card-body">
        <a href="{{ route('admin.officials.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nouvel Officiel
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($officials->count())
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Poste</th>
                            <th>Département</th>
                            <th>Téléphone</th>
                            <th>Statut</th>
                            <th>{{ __('messages.Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($officials as $official)
                            <tr>
                                <td>{{ $official->user->name ?? 'N/A' }}</td>
                                <td>{{ $official->position_fr }}</td>
                                <td>{{ $official->department->name_fr ?? 'N/A' }}</td>
                                <td>{{ $official->phone ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge {{ $official->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $official->status === 'active' ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.officials.edit', $official) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.officials.destroy', $official) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr ?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $officials->links() }}
        @else
            <p class="text-muted">Aucun officiel trouvé.</p>
        @endif
    </div>
</div>
@endsection