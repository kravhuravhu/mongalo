@extends('admin.layouts.admin')

@section('title', 'Create Book · ' . env('PROJECT_NAME', 'The Collective'))
@section('page-title', 'Create Book')
@section('breadcrumb', 'Books / Create')

@section('content')

<div class="books-form">
    <div class="books-form__header">
        <a href="{{ route('admin.books.index') }}" class="btn btn--secondary">
            <i class="fas fa-arrow-left"></i> Back to Books
        </a>
    </div>

    <div class="books-form__card">
        <form method="POST" action="{{ route('admin.books.store') }}" class="admin-form form-loading" id="bookCreateForm">
            @csrf

            {{-- ─── TITLE ─── --}}
            <div class="form-group">
                <label for="title">Title <span class="required">*</span></label>
                <input type="text" name="title" id="title" placeholder="Divine Identity" value="{{ old('title') }}" required>
                @error('title')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- ─── SUBTITLE ─── --}}
            <div class="form-group">
                <label for="subtitle">Subtitle</label>
                <input type="text" name="subtitle" id="subtitle" placeholder="Discovering Who You Are in Christ" value="{{ old('subtitle') }}">
                @error('subtitle')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- ─── DESCRIPTION ─── --}}
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="5" placeholder="Write a brief description of the book...">{{ old('description') }}</textarea>
                @error('description')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- ─── PRICE & FREE ─── --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="price">Price (ZAR) <span class="required">*</span></label>
                    <input type="number" name="price" id="price" placeholder="199.99" step="0.01" min="0" value="{{ old('price', '0.00') }}" required>
                    @error('price')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                    <span class="form-help">Set to 0 for free resources</span>
                </div>

                <div class="form-group">
                    <label for="cover_color">Cover Color</label>
                    <input type="color" name="cover_color" id="cover_color" value="{{ old('cover_color', '#a67c4e') }}">
                    @error('cover_color')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                    <span class="form-help">Choose a color for the book cover preview</span>
                </div>
            </div>

            {{-- ─── CHECKBOXES ─── --}}
            <div class="form-row">
                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="is_free" value="1" {{ old('is_free') ? 'checked' : '' }}>
                        Free Resource
                    </label>
                    <span class="form-help">Check if this is a free resource</span>
                </div>

                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                        Featured Book
                    </label>
                    <span class="form-help">Check to highlight on the homepage</span>
                </div>
            </div>

            {{-- ─── SUBMIT ─── --}}
            <div class="books-form__actions">
                <button type="submit" class="btn btn--primary btn--lg" id="submitBtn">
                    <i class="fas fa-save"></i> 
                    <span class="btn-text">Create Book</span>
                    <span class="btn-loader" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i> Creating...
                    </span>
                </button>
                <a href="{{ route('admin.books.index') }}" class="btn btn--secondary btn--lg">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/admin/books.css') }}">
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ─── FORM SUBMIT WITH LOADING ───
        const form = document.getElementById('bookCreateForm');
        const submitBtn = document.getElementById('submitBtn');
        
        if (form && submitBtn) {
            form.addEventListener('submit', function() {
                const btnText = submitBtn.querySelector('.btn-text');
                const btnLoader = submitBtn.querySelector('.btn-loader');
                const icon = submitBtn.querySelector('i');
                
                submitBtn.disabled = true;
                if (btnText) btnText.style.display = 'none';
                if (btnLoader) btnLoader.style.display = 'inline';
                if (icon) icon.style.display = 'none';
            });
        }
    });
</script>
@endpush