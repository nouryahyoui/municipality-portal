@extends('layouts.app')

@section('title', 'Déposer une Plainte')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="mb-4">Déposer une Plainte</h2>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('services.complaint.submit') }}" method="POST" id="complaintForm">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Catégorie *</label>
                            <select class="form-select" name="category" required>
                                <option value="">Choisir une catégorie</option>
                                <option value="infrastructure">Infrastructure</option>
                                <option value="services">Services</option>
                                <option value="staff">Personnel</option>
                                <option value="cleanliness">Propreté</option>
                                <option value="security">Sécurité</option>
                                <option value="other">Autre</option>
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
                            <label class="form-label">Localisation</label>
                            <input type="text" class="form-control" name="location" placeholder="Adresse ou lieu concerné">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description *</label>
                            <textarea class="form-control @error('description_fr') is-invalid @enderror"
                                name="description_fr" rows="5" required placeholder="Décrivez votre plainte...">{{ old('description_fr') }}</textarea>
                            @error('description_fr')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="button" class="btn btn-danger" onclick="confirmSubmit()">
                            Soumettre la Plainte
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
                Êtes-vous sûr de vouloir soumettre cette plainte ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                <button type="button" class="btn btn-danger" onclick="document.getElementById('complaintForm').submit()">Oui, soumettre</button>
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