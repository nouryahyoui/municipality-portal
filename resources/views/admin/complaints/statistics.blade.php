@extends('layouts.admin')

@section('page-title', 'Statistiques Plaintes')
@section('title', 'Statistiques Plaintes')

@section('content')
<div class="page-header">
    <h1>Statistiques des Plaintes</h1>
    <p class="text-muted">Vue d'ensemble des plaintes citoyennes</p>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-2">
        <div class="card bg-secondary text-white text-center">
            <div class="card-body">
                <h3>{{ $stats['total'] }}</h3>
                <small>Total</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-danger text-white text-center">
            <div class="card-body">
                <h3>{{ $stats['new'] }}</h3>
                <small>Nouvelles</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-warning text-white text-center">
            <div class="card-body">
                <h3>{{ $stats['in_investigation'] }}</h3>
                <small>En investigation</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-success text-white text-center">
            <div class="card-body">
                <h3>{{ $stats['resolved'] }}</h3>
                <small>Résolues</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-info text-white text-center">
            <div class="card-body">
                <h3>{{ $stats['dismissed'] }}</h3>
                <small>Rejetées</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-dark text-white text-center">
            <div class="card-body">
                <h3>{{ $stats['closed'] }}</h3>
                <small>Clôturées</small>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body text-center">
        <a href="{{ route('admin.complaints.index') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Retour aux Plaintes
        </a>
    </div>
</div>
@endsection