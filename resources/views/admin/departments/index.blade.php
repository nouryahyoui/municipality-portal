@extends('layouts.admin')

@section('page-title', __('messages.Departments'))
@section('title', __('messages.Departments'))

@section('content')
<div class="page-header">
    <h1>{{ __('messages.Departments') }}</h1>
    <p class="text-muted">Gérer les départements municipaux</p>
</div>

<div class="card mb-3">
    <div class="card-body">
        <a href="{{ route('admin.departments.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nouveau Département
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($departments->count())
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Téléphone</th>
                            <th>Email</th>
                            <th>Statut</th>
                            <th>{{ __('messages.Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($departments as $department)
                            <tr>
                                <td>{{ $department->name_fr }}</td>
                                <td>{{ $department->phone ?? 'N/A' }}</td>
                                <td>{{ $department->email ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge {{ $department->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $department->is_active ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.departments.edit', $department) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.departments.destroy', $department) }}" method="POST" class="d-inline">
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
            {{ $departments->links() }}
        @else
            <p class="text-muted">Aucun département trouvé.</p>
        @endif
    </div>
</div>
@endsection