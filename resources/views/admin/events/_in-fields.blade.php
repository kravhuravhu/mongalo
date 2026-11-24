@php
    $categories = config('in.brands.community.event_categories');
    $weekdayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    $currentRecurrence = old('recurrence', $event->recurrence ?? 'none');
    $currentWeekdays = old('recurrence_weekdays', $event->recurrence_weekdays ?? []);
@endphp

{{-- ─── CATEGORY ─── --}}
<div class="form-group" style="max-width: 320px;">
    <label for="category">Category <span class="required">*</span></label>
    <select name="category" id="category" required>
        @foreach($categories as $key => $category)
            <option value="{{ $key }}" {{ old('category', $event->category ?? 'other') === $key ? 'selected' : '' }}>{{ $category['label'] }}</option>
        @endforeach
    </select>
    @error('category')
        <span class="form-error">{{ $message }}</span>
    @enderror
</div>

{{-- ─── POSTER ─── --}}
<div class="form-group">
    <label for="poster_image">Poster</label>
    @if(!empty($event->poster_image))
        <div style="margin-bottom: 10px;">
            <img src="{{ $event->poster_url }}" alt="Current poster" style="max-width: 160px; border-radius: 8px;">
            <label style="display: flex; align-items: center; gap: 8px; margin-top: 8px; cursor: pointer;">
                <input type="checkbox" name="remove_poster" value="1"> Remove current poster
            </label>
        </div>
    @endif
    <input type="file" name="poster_image" id="poster_image" accept="image/jpeg,image/png,image/webp">
    @error('poster_image')
        <span class="form-error">{{ $message }}</span>
    @enderror
    <span class="form-help">Shown in the iN Community hero and downloadable. JPG, PNG or WebP, 9:14 portrait works best, max 6MB.</span>
</div>

{{-- ─── RECURRENCE ─── --}}
<div class="form-row">
    <div class="form-group">
        <label for="recurrence">Repeats</label>
        <select name="recurrence" id="recurrence">
            <option value="none" {{ $currentRecurrence === 'none' ? 'selected' : '' }}>Does not repeat</option>
            <option value="daily" {{ $currentRecurrence === 'daily' ? 'selected' : '' }}>Daily</option>
            <option value="weekly" {{ $currentRecurrence === 'weekly' ? 'selected' : '' }}>Weekly</option>
            <option value="monthly" {{ $currentRecurrence === 'monthly' ? 'selected' : '' }}>Monthly</option>
            <option value="yearly" {{ $currentRecurrence === 'yearly' ? 'selected' : '' }}>Yearly</option>
        </select>
        @error('recurrence')
            <span class="form-error">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group" id="recurrenceInterval" style="{{ $currentRecurrence === 'none' ? 'display: none;' : '' }}">
        <label for="recurrence_interval">Every</label>
        <input type="number" name="recurrence_interval" id="recurrence_interval" min="1" max="52" value="{{ old('recurrence_interval', $event->recurrence_interval ?? 1) }}">
        <span class="form-help">1 = every, 2 = every second, and so on</span>
    </div>
</div>

<div class="form-group" id="recurrenceWeekdays" style="{{ $currentRecurrence === 'weekly' ? '' : 'display: none;' }}">
    <label>On these days</label>
    <div style="display: flex; flex-wrap: wrap; gap: 14px;">
        @foreach($weekdayNames as $index => $dayName)
            <label style="display: flex; align-items: center; gap: 6px; cursor: pointer;">
                <input type="checkbox" name="recurrence_weekdays[]" value="{{ $index }}" {{ in_array($index, (array) $currentWeekdays) ? 'checked' : '' }}> {{ $dayName }}
            </label>
        @endforeach
    </div>
    <span class="form-help">Leave empty to use the weekday of the start date</span>
</div>

<div class="form-group" id="recurrenceEnds" style="max-width: 260px; {{ $currentRecurrence === 'none' ? 'display: none;' : '' }}">
    <label for="recurrence_ends_on">Stops repeating on</label>
    <input type="date" name="recurrence_ends_on" id="recurrence_ends_on" value="{{ old('recurrence_ends_on', optional($event->recurrence_ends_on ?? null)->format('Y-m-d')) }}">
    @error('recurrence_ends_on')
        <span class="form-error">{{ $message }}</span>
    @enderror
    <span class="form-help">Leave empty to repeat until you change it. The date above is the first occurrence.</span>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('recurrence');
        if (!select) return;
        function sync() {
            const value = select.value;
            document.getElementById('recurrenceInterval').style.display = value === 'none' ? 'none' : '';
            document.getElementById('recurrenceWeekdays').style.display = value === 'weekly' ? '' : 'none';
            document.getElementById('recurrenceEnds').style.display = value === 'none' ? 'none' : '';
        }
        select.addEventListener('change', sync);
    });
</script>