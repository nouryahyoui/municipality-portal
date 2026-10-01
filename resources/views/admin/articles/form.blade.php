@extends('layouts.admin')

@section('page-title', isset($article) ? __('messages.Edit') . ' ' . __('messages.Articles') : __('messages.New Article'))
@section('title', isset($article) ? __('messages.Edit') . ' ' . __('messages.Articles') : __('messages.New Article'))

@section('content')
<div class="page-header">
    <h1>{{ isset($article) ? __('messages.Edit') . ' ' . __('messages.Articles') : __('messages.New Article') }}</h1>
</div>

<form method="POST" action="{{ isset($article) ? route('admin.articles.update', $article) : route('admin.articles.store') }}" enctype="multipart/form-data">
    @csrf
    @if(isset($article))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">{{ __('messages.Articles') }} - FR</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title_fr" class="form-label">{{ __('messages.Title') }} (FR) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title_fr') is-invalid @enderror" id="title_fr" name="title_fr"
                               value="{{ old('title_fr', $article->title_fr ?? '') }}" required>
                        @error('title_fr')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="summary_fr" class="form-label">Résumé (FR)</label>
                        <textarea class="form-control @error('summary_fr') is-invalid @enderror" id="summary_fr" name="summary_fr" rows="3">{{ old('summary_fr', $article->summary_fr ?? '') }}</textarea>
                        @error('summary_fr')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content_fr" class="form-label">{{ __('messages.Description') }} (FR) <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content_fr') is-invalid @enderror" id="content_fr" name="content_fr" rows="8" required>{{ old('content_fr', $article->content_fr ?? '') }}</textarea>
                        @error('content_fr')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">{{ __('messages.Articles') }} - EN</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title_en" class="form-label">{{ __('messages.Title') }} (EN) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title_en') is-invalid @enderror" id="title_en" name="title_en"
                               value="{{ old('title_en', $article->title_en ?? '') }}" required>
                        @error('title_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="summary_en" class="form-label">Summary (EN)</label>
                        <textarea class="form-control" id="summary_en" name="summary_en" rows="3">{{ old('summary_en', $article->summary_en ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="content_en" class="form-label">{{ __('messages.Description') }} (EN) <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content_en') is-invalid @enderror" id="content_en" name="content_en" rows="8" required>{{ old('content_en', $article->content_en ?? '') }}</textarea>
                        @error('content_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">{{ __('messages.Articles') }} - AR</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title_ar" class="form-label">{{ __('messages.Title') }} (AR) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title_ar') is-invalid @enderror" id="title_ar" name="title_ar" dir="rtl"
                               value="{{ old('title_ar', $article->title_ar ?? '') }}" required>
                        @error('title_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="summary_ar" class="form-label">ملخص (AR)</label>
                        <textarea class="form-control" id="summary_ar" name="summary_ar" dir="rtl" rows="3">{{ old('summary_ar', $article->summary_ar ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="content_ar" class="form-label">{{ __('messages.Description') }} (AR) <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content_ar') is-invalid @enderror" id="content_ar" name="content_ar" dir="rtl" rows="8" required>{{ old('content_ar', $article->content_ar ?? '') }}</textarea>
                        @error('content_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Publishing -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">{{ __('messages.Status') }}</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="publish" name="publish" value="1"
                                   {{ old('publish', isset($article) && $article->status === 'published') ? 'checked' : '' }}>
                            <label class="form-check-label" for="publish">
                                {{ __('messages.Published') }}
                            </label>
                        </div>
                    </div>

                    <input type="hidden" name="status" value="{{ old('status', $article->status ?? 'draft') }}">

                    <div class="mb-3">
                        <label for="category_id" class="form-label">{{ __('messages.Category') }} <span class="text-danger">*</span></label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                            <option value="">{{ __('messages.All Categories') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                        {{ old('category_id', $article->category_id ?? null) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name ?? $category->name_fr ?? '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Featured Image -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">{{ __('messages.Images') }}</h6>
                </div>
                <div class="card-body">
                    @if(isset($article) && $article->featured_image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title_fr }}" class="img-fluid rounded" style="max-height: 150px;">
                        </div>
                    @endif

                    <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                           id="featured_image" name="featured_image" accept="image/*">
                    <small class="text-muted">JPG, PNG. Max 2MB</small>
                    @error('featured_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        <i class="bi bi-check-circle"></i>
                        {{ isset($article) ? __('messages.Edit') : __('messages.New Article') }}
                    </button>
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary w-100">
                        Annuler
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection