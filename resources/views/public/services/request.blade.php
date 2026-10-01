@extends('layouts.app')

@section('title', 'Soumettre une Demande')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="mb-4">Soumettre une Demande</h2>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('services.request.submit') }}" method="POST" enctype="multipart/form-data" id="requestForm">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Sélectionner un service</label>
                            <select class="form-select" name="service_id">
                                <option value="">Choisir un service</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name_fr }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Priorité *</label>
                            <select class="form-select" name="priority" required>
                                <option value="low">Faible</option>
                                <option value="medium" selected>Moyen</option>
                                <option value="high">Élevé</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description *</label>
                            <textarea class="form-control @error('description_fr') is-invalid @enderror"
                                name="description_fr" rows="5" required placeholder="Décrivez votre demande...">{{ old('description_fr') }}</textarea>
                            @error('description_fr')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pièces jointes</label>
                            <input type="file" class="form-control" name="attachments">
                            <small class="text-muted">Formats acceptés: PDF, JPG, PNG (max 5MB)</small>
                        </div>

                        <button type="button" class="btn btn-primary" onclick="confirmSubmit()">
                            Soumettre
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-secondary ms-2">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Confirmation -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir soumettre cette demande ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('requestForm').submit()">Oui, soumettre</button>
            </div>
        </div>
    </div>
</div>

<script>
function confirmSubmit() {
    var modal = new bootstrap.Modal(document.getElementById('confirmModal'));
    modal.show();
}
</script>
@endsection