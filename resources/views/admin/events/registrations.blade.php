@extends('layouts.admin')

@section('page-title', __('messages.Registrations'))
@section('title', __('messages.Registrations'))

@section('content')
<div class="page-header">
    <h1>{{ __('messages.Registrations') }} — {{ $event->title_fr }}</h1>
    <p class="text-muted">{{ $event->start_date->format('d M Y') }} — {{ $event->location_fr ?? 'N/A' }}</p>
</div>

<div class="card mb-4">
    <div class="card-body">
        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> {{ __('messages.Events') }}
        </a>
        <span class="badge bg-secondary ms-2">
            {{ $event->registrations }} / {{ $event->capacity ?? '∞' }} {{ __('messages.Registrations') }}
        </span>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($registrations->count())
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('messages.Author') }}</th>
                            <th>Email</th>
                            <th>{{ __('messages.Date') }}</th>
                            <th>{{ __('messages.Status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations as $registration)
                            <tr>
                                <td>{{ $registration->user->name ?? 'N/A' }}</td>
                                <td>{{ $registration->email }}</td>
                                <td>{{ $registration->created_at->format('d M Y') }}</td>
                                <td>
                                    <span class="badge {{ $registration->status === 'confirmed' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($registration->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $registrations->links() }}
        @else
            <p class="text-muted">{{ __('messages.No requests found.') }}</p>
        @endif
    </div>
</div>
@endsection