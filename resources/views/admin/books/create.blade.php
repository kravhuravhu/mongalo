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
        <form method="POST" action="{{ route('admin.books.store') }}" class="admin-form form-loading" id="bookCreateForm" enctype="multipart/form-data">
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

            {{-- ─── PRICE ─── --}}
            <div class="form-group">
                <label for="price">Price (ZAR) <span class="required">*</span></label>
                <input type="number" name="price" id="price" placeholder="199.99" step="0.01" min="0" value="{{ old('price', '0.00') }}" required>
                @error('price')
                    <span class="form-error">{{ $message }}</span>
                @enderror
                <span class="form-help">Set to 0 for free resources</span>
            </div>

            {{-- ─── COVER IMAGE ─── --}}
            <div class="form-group">
                <label for="cover_image">Cover Image</label>
                <input type="file" name="cover_image" id="cover_image" accept="image/*" class="file-input">
                <span class="form-help">Upload a book cover image (JPG, PNG, WEBP). Max 2MB. Recommended size: 600x900px</span>
                @error('cover_image')
                    <span class="form-error">{{ $message }}</span>
                @enderror
                <div class="file-preview" id="coverPreview" style="display: none; margin-top: 12px;">
                    <img src="" alt="Cover preview" style="max-width: 150px; max-height: 200px; border-radius: 8px; border: 1px solid var(--border);">
                </div>
            </div>

            {{-- ─── COVER COLOR (FALLBACK) ─── --}}
            <div class="form-group">
                <label for="cover_color">Cover Color (Fallback) <span class="required">*</span></label>
                <input type="color" name="cover_color" id="cover_color" value="{{ old('cover_color', '#a67c4e') }}">
                @error('cover_color')
                    <span class="form-error">{{ $message }}</span>
                @enderror
                <span class="form-help">Used if no cover image is uploaded</span>
            </div>

            {{-- ─── BOOK FILE ─── --}}
            <div class="form-group">
                <label for="book_file">Book File <span class="required">*</span></label>
                <input type="file" name="book_file" id="book_file" accept=".pdf,.epub,.mobi,.docx" required class="file-input">
                <span class="form-help">Upload the book file (PDF, EPUB, MOBI, DOCX). Max 50MB</span>
                @error('book_file')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- ─── FILE TYPE ─── --}}
            <div class="form-group" style="max-width: 200px;">
                <label for="file_type">File Type <span class="required">*</span></label>
                <select name="file_type" id="file_type" required>
                    <option value="pdf" {{ old('file_type') === 'pdf' ? 'selected' : '' }}>PDF</option>
                    <option value="epub" {{ old('file_type') === 'epub' ? 'selected' : '' }}>EPUB</option>
                    <option value="mobi" {{ old('file_type') === 'mobi' ? 'selected' : '' }}>MOBI</option>
                    <option value="docx" {{ old('file_type') === 'docx' ? 'selected' : '' }}>DOCX</option>
                </select>
                @error('file_type')
                    <span class="form-error">{{ $message }}</span>
                @enderror
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

        /* ─── COVER IMAGE PREVIEW ─── */
        const coverInput = document.getElementById('cover_image');
        const preview = document.getElementById('coverPreview');
        const previewImg = preview.querySelector('img');

        if (coverInput && preview) {
            coverInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(this.files[0]);
                } else {
                    preview.style.display = 'none';
                }
            });
        }
    });
</script>
@endpush