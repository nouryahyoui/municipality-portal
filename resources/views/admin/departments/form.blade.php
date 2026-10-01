@extends('layouts.admin')

@section('page-title', $department->exists ? 'Modifier Département' : 'Nouveau Département')
@section('title', $department->exists ? 'Modifier Département' : 'Nouveau Département')

@section('content')
<div class="page-header">
    <h1>{{ $department->exists ? 'Modifier Département' : 'Nouveau Département' }}</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ $department->exists ? route('admin.departments.update', $department) : route('admin.departments.store') }}" method="POST">
            @csrf
            @if($department->exists)
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Nom (FR) *</label>
                    <input type="text" class="form-control" name="name_fr" value="{{ old('name_fr', $department->name_fr ?? '') }}" required>
                    @error('name_fr') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Nom (EN) *</label>
                    <input type="text" class="form-control" name="name_en" value="{{ old('name_en', $department->name_en ?? '') }}" required>
                    @error('name_en') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Nom (AR) *</label>
                    <input type="text" class="form-control" name="name_ar" dir="rtl" value="{{ old('name_ar', $department->name_ar ?? '') }}" required>
                    @error('name_ar') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Description (FR)</label>
                    <textarea class="form-control" name="description_fr" rows="3">{{ old('description_fr', $department->description_fr ?? '') }}</textarea>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Description (EN)</label>
                    <textarea class="form-control" name="description_en" rows="3">{{ old('description_en', $department->description_en ?? '') }}</textarea>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Description (AR)</label>
                    <textarea class="form-control" name="description_ar" dir="rtl" rows="3">{{ old('description_ar', $department->description_ar ?? '') }}</textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Téléphone</label>
                    <input type="text" class="form-control" name="phone" value="{{ old('phone', $department->phone ?? '') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email', $department->email ?? '') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Localisation</label>
                    <input type="text" class="form-control" name="location" value="{{ old('location', $department->location ?? '') }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Ordre</label>
                    <input type="number" class="form-control" name="order" value="{{ old('order', $department->order ?? 0) }}">
                </div>
                <div class="col-md-4 mb-3 d-flex align-items-end">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $department->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label">Actif</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">
                    {{ $department->exists ? 'Mettre à jour' : 'Créer' }}
                </button>
                <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection