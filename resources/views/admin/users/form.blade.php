@extends('layouts.admin')

@section('page-title', $user->exists ? 'Modifier Utilisateur' : 'Nouvel Utilisateur')
@section('title', $user->exists ? 'Modifier Utilisateur' : 'Nouvel Utilisateur')

@section('content')
<div class="page-header">
    <h1>{{ $user->exists ? 'Modifier Utilisateur' : 'Nouvel Utilisateur' }}</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST">
            @csrf
            @if($user->exists)
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nom *</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $user->name ?? '') }}" required>
                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email *</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email', $user->email ?? '') }}" required>
                    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mot de passe {{ $user->exists ? '(laisser vide pour ne pas changer)' : '*' }}</label>
                    <input type="password" class="form-control" name="password" {{ $user->exists ? '' : 'required' }}>
                    @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Confirmer mot de passe</label>
                    <input type="password" class="form-control" name="password_confirmation">
                </div>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">
                    {{ $user->exists ? 'Mettre à jour' : 'Créer' }}
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
