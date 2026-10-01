@extends('layouts.admin')

@section('page-title', __('messages.Audit Log'))
@section('title', __('messages.Audit Log'))

@section('content')
<div class="page-header">
    <h1>{{ __('messages.Audit Log') }}</h1>
    <p class="text-muted">Journal des activités du système</p>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card bg-primary text-white text-center">
            <div class="card-body">
                <h3>{{ $stats['total_users'] }}</h3>
                <small>Total Utilisateurs</small>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-success text-white text-center">
            <div class="card-body">
                <h3>{{ $stats['recent_users'] }}</h3>
                <small>Nouveaux utilisateurs (7 derniers jours)</small>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Activités récentes</h5>
    </div>
    <div class="card-body">
        @if($entries->count())
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entries as $entry)
                            <tr>
                                <td><span class="badge bg-info">{{ $entry->type ?? 'N/A' }}</span></td>
                                <td>{{ $entry->created_at ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted">Aucune activité enregistrée pour le moment.</p>
        @endif
    </div>
</div>
@endsection