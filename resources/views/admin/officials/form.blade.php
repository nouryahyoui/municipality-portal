@extends('layouts.admin')

@section('page-title', $official->exists ? 'Modifier Officiel' : 'Nouvel Officiel')
@section('title', $official->exists ? 'Modifier Officiel' : 'Nouvel Officiel')

@section('content')
<div class="page-header">
    <h1>{{ $official->exists ? 'Modifier Officiel' : 'Nouvel Officiel' }}</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ $official->exists ? route('admin.officials.update', $official) : route('admin.officials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if($official->exists)
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Utilisateur *</label>
                    <select class="form-select" name="user_id" required>
                        <option value="">-- Sélectionner --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $official->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Département *</label>
                    <select class="form-select" name="department_id" required>
                        <option value="">-- Sélectionner --</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id', $official->department_id ?? '') == $department->id ? 'selected' : '' }}>
                                {{ $department->name_fr }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Poste (FR) *</label>
                    <input type="text" class="form-control" name="position_fr" value="{{ old('position_fr', $official->position_fr ?? '') }}" required>
                    @error('position_fr') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Poste (EN) *</label>
                    <input type="text" class="form-control" name="position_en" value="{{ old('position_en', $official->position_en ?? '') }}" required>
                    @error('position_en') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Poste (AR) *</label>
                    <input type="text" class="form-control" name="position_ar" dir="rtl" value="{{ old('position_ar', $official->position_ar ?? '') }}" required>
                    @error('position_ar') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Téléphone</label>
                    <input type="text" class="form-control" name="phone" value="{{ old('phone', $official->phone ?? '') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email', $official->email ?? '') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Bureau</label>
                    <input type="text" class="form-control" name="office_location" value="{{ old('office_location', $official->office_location ?? '') }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Statut *</label>
                    <select class="form-select" name="status" required>
                        <option value="active" {{ old('status', $official->status ?? '') === 'active' ? 'selected' : '' }}>Actif</option>
                        <option value="inactive" {{ old('status', $official->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactif</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Photo</label>
                    @if($official->exists && $official->photo)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $official->photo) }}" class="img-fluid rounded" style="max-height: 100px;">
                        </div>
                    @endif
                    <input type="file" class="form-control" name="photo" accept="image/*">
                </div>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">
                    {{ $official->exists ? 'Mettre à jour' : 'Créer' }}
                </button>
                <a href="{{ route('admin.officials.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection 