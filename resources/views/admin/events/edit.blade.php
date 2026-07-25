@extends('admin.layouts.admin')

@section('title', 'Edit Event · ' . env('PROJECT_NAME', 'The Collective'))
@section('page-title', 'Edit Event')
@section('breadcrumb', 'Events / Edit')

@section('content')

<div class="events-form">
    <div class="events-form__header">
        <a href="{{ route('admin.events.index') }}" class="btn btn--secondary">
            <i class="fas fa-arrow-left"></i> Back to Events
        </a>
    </div>

    <div class="events-form__card">
        <form method="POST" action="{{ route('admin.events.update', $event) }}" class="admin-form form-loading" id="eventEditForm">
            @csrf
            @method('PUT')

            {{-- ─── TITLE ─── --}}
            <div class="form-group">
                <label for="title">Title <span class="required">*</span></label>
                <input type="text" name="title" id="title" placeholder="Sunday Service" value="{{ old('title', $event->title) }}" required>
                @error('title')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- ─── DESCRIPTION ─── --}}
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="4" placeholder="Describe the event...">{{ old('description', $event->description) }}</textarea>
                @error('description')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- ─── DATE & TIME ─── --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="date">Date <span class="required">*</span></label>
                    <input type="date" name="date" id="date" value="{{ old('date', $event->date->format('Y-m-d')) }}" required>
                    @error('date')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="time">Time <span class="required">*</span></label>
                    <input type="time" name="time" id="time" value="{{ old('time', $event->time) }}" required>
                    @error('time')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- ─── LOCATION ─── --}}
            <div class="form-group">
                <label for="location">Location <span class="required">*</span></label>
                <input type="text" name="location" id="location" placeholder="Sandton Convention Centre" value="{{ old('location', $event->location) }}" required>
                @error('location')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- ─── CAPACITY ─── --}}
            <div class="form-group" style="max-width: 200px;">
                <label for="capacity">Capacity</label>
                <input type="number" name="capacity" id="capacity" placeholder="100" value="{{ old('capacity', $event->capacity) }}" min="1">
                @error('capacity')
                    <span class="form-error">{{ $message }}</span>
                @enderror
                <span class="form-help">Leave empty for unlimited</span>
            </div>

            {{-- ─── PAST EVENT ─── --}}
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" name="is_past" value="1" {{ old('is_past', $event->is_past) ? 'checked' : '' }}>
                    Mark as Past Event
                </label>
                <span class="form-help">Check if this event has already happened</span>
            </div>

            {{-- ─── SUBMIT ─── --}}
            <div class="events-form__actions">
                <button type="submit" class="btn btn--primary btn--lg" id="submitBtn">
                    <i class="fas fa-save"></i> 
                    <span class="btn-text">Update Event</span>
                    <span class="btn-loader" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i> Updating...
                    </span>
                </button>
                <a href="{{ route('admin.events.index') }}" class="btn btn--secondary btn--lg">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/admin/events.css') }}">
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('eventEditForm');
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