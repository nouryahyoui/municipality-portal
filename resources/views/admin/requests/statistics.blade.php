@extends('layouts.admin')

@section('page-title', 'Statistiques Demandes')
@section('title', 'Statistiques Demandes')

@section('content')
<div class="page-header">
    <h1>Statistiques des Demandes</h1>
    <p class="text-muted">Vue d'ensemble des demandes citoyennes</p>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card bg-secondary text-white text-center">
            <div class="card-body">
                <h3>{{ $stats['total'] ?? 0 }}</h3>
                <small>Total</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white text-center">
            <div class="card-body">
                <h3>{{ $stats['pending'] ?? 0 }}</h3>
                <small>En attente</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white text-center">
            <div class="card-body">
                <h3>{{ $stats['in_progress'] ?? 0 }}</h3>
                <small>En cours</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white text-center">
            <div class="card-body">
                <h3>{{ $stats['completed'] ?? 0 }}</h3>
                <small>Terminées</small>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body text-center">
        <a href="{{ route('admin.requests.index') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Retour aux Demandes
        </a>
    </div>
</div>
@endsection