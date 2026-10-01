@extends('layouts.admin')

@section('page-title', __('messages.Permissions'))
@section('title', __('messages.Permissions'))

@section('content')
<div class="page-header">
    <h1>{{ __('messages.Permissions') }}</h1>
    <p class="text-muted">Gérer les rôles et permissions des utilisateurs</p>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Rôles disponibles -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Rôles du système</h5>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($roles as $role)
                <div class="col-md-3 mb-3">
                    <div class="card border">
                        <div class="card-body text-center">
                            <h5 class="text-capitalize">{{ $role->name }}</h5>
                            <span class="badge bg-primary">{{ $role->permissions->count() }} permissions</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Assigner rôle aux utilisateurs -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Assigner un rôle à un utilisateur</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Email</th>
                        <th>Rôle actuel</th>
                        <th>Changer le rôle</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="badge bg-info">{{ $role->name }}</span>
                                @endforeach
                                @if($user->roles->isEmpty())
                                    <span class="badge bg-secondary">Aucun rôle</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.permissions.assignRole', $user) }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    <select class="form-select form-select-sm" name="role" style="width: 150px;">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                {{ ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">Assigner</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Liste des permissions -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Toutes les permissions</h5>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($permissions as $group => $perms)
                <div class="col-md-4 mb-3">
                    <h6 class="text-capitalize fw-bold">{{ $group }}</h6>
                    @foreach($perms as $permission)
                        <span class="badge bg-light text-dark me-1 mb-1">{{ $permission->name }}</span>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection