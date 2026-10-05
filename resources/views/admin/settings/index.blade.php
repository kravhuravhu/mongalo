@extends('admin.layouts.admin')

@section('title', 'Settings · ' . env('PROJECT_NAME', 'IN.iN'))
@section('page-title', 'Settings')
@section('breadcrumb', 'System / Settings')

@section('content')

<div class="settings-form">

    {{-- ─── HEADER ─── --}}
    <div class="settings-form__header">
        <p class="settings-form__intro">
            Control shipping fees, currency, and hard-copy policies. Changes take effect immediately.
        </p>
    </div>

    {{-- ─── FORM ─── --}}
    <form method="POST" action="{{ route('admin.settings.update') }}" class="admin-form" id="settingsForm">
        @csrf
        @method('PUT')

        {{-- ═══ GENERAL ═══ --}}
        <div class="settings-form__card">
            <div class="settings-form__card-header">
                <div class="settings-form__card-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <div>
                    <h3 class="settings-form__card-title">General</h3>
                    <p class="settings-form__card-desc">Site-wide currency and contact details.</p>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="site_currency_symbol">Currency Symbol</label>
                    <input type="text" name="site_currency_symbol" id="site_currency_symbol"
                        value="{{ old('site_currency_symbol', settings('site.currency_symbol', 'R')) }}"
                        placeholder="R" maxlength="10">
                    <span class="form-help">Shown before amounts (e.g. R 199.50)</span>
                </div>

                <div class="form-group">
                    <label for="site_currency_code">Currency Code</label>
                    <input type="text" name="site_currency_code" id="site_currency_code"
                        value="{{ old('site_currency_code', settings('site.currency_code', 'ZAR')) }}"
                        placeholder="ZAR" maxlength="10">
                    <span class="form-help">Used by payment gateways</span>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="site_support_email">Support Email</label>
                    <input type="email" name="site_support_email" id="site_support_email"
                        value="{{ old('site_support_email', settings('site.support_email')) }}"
                        placeholder="hello@example.com">
                </div>

                <div class="form-group">
                    <label for="site_support_whatsapp">Support WhatsApp</label>
                    <input type="text" name="site_support_whatsapp" id="site_support_whatsapp"
                        value="{{ old('site_support_whatsapp', settings('site.support_whatsapp')) }}"
                        placeholder="+27 71 000 0000">
                </div>
            </div>

            <div class="form-group">
                <label for="site_delivery_notice">Delivery Notice</label>
                <textarea name="site_delivery_notice" id="site_delivery_notice" rows="2"
                    placeholder="A short note shown under the hard copy option.">{{ old('site_delivery_notice', settings('site.delivery_notice')) }}</textarea>
            </div>
        </div>

        {{-- ═══ SHIPPING REGIONS ═══ --}}
        <div class="settings-form__card">
            <div class="settings-form__card-header">
                <div class="settings-form__card-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <div>
                    <h3 class="settings-form__card-title">Shipping Regions</h3>
                    <p class="settings-form__card-desc">Flat fees for hard-copy orders. Leave a region blank to hide it.</p>
                </div>
            </div>

            @for ($i = 1; $i <= 4; $i++)
                <div class="settings-form__region">
                    <span class="settings-form__region-label">Region {{ $i }}</span>

                    <div class="form-row">
                        <div class="form-group" style="max-width: 140px;">
                            <label>Key</label>
                            <input type="text" name="shipping_region_{{ $i }}_key"
                                value="{{ old("shipping_region_{$i}_key", settings("shipping.region_{$i}_key")) }}"
                                placeholder="za">
                        </div>

                        <div class="form-group">
                            <label>Label</label>
                            <input type="text" name="shipping_region_{{ $i }}_label"
                                value="{{ old("shipping_region_{$i}_label", settings("shipping.region_{$i}_label")) }}"
                                placeholder="South Africa">
                        </div>

                        <div class="form-group" style="max-width: 140px;">
                            <label>Fee</label>
                            <input type="number" name="shipping_region_{{ $i }}_fee"
                                value="{{ old("shipping_region_{$i}_fee", settings("shipping.region_{$i}_fee")) }}"
                                step="0.01" min="0" placeholder="80.00">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Delivery Estimate</label>
                        <input type="text" name="shipping_region_{{ $i }}_days"
                            value="{{ old("shipping_region_{$i}_days", settings("shipping.region_{$i}_days")) }}"
                            placeholder="3 – 5 business days">
                    </div>
                </div>
            @endfor
        </div>

        {{-- ═══ FREE RESOURCES POLICY ═══ --}}
        <div class="settings-form__card">
            <div class="settings-form__card-header">
                <div class="settings-form__card-icon">
                    <i class="fas fa-gift"></i>
                </div>
                <div>
                    <h3 class="settings-form__card-title">Free Resources Policy</h3>
                    <p class="settings-form__card-desc">Control whether free resources can be ordered as printed copies.</p>
                </div>
            </div>

            @php
                $resourcesEnabled = (bool) settings('resources.hardcopy_enabled', false);
                $resourcesPaid    = (bool) settings('resources.hardcopy_paid', false);
            @endphp

            <div class="settings-form__checkboxes">
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="resources_hardcopy_enabled" value="1"
                            {{ old('resources_hardcopy_enabled', $resourcesEnabled) ? 'checked' : '' }}>
                        Allow printed copies of free resources
                    </label>
                    <span class="form-help">If off, free resources are download-only.</span>
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" name="resources_hardcopy_paid" value="1"
                            {{ old('resources_hardcopy_paid', $resourcesPaid) ? 'checked' : '' }}>
                        Charge shipping for printed free resources
                    </label>
                    <span class="form-help">If off, the ministry covers postage.</span>
                </div>
            </div>

            <div class="form-group" style="max-width: 240px;">
                <label for="resources_hardcopy_fee">Shipping Fee</label>
                <input type="number" name="resources_hardcopy_fee" id="resources_hardcopy_fee"
                    value="{{ old('resources_hardcopy_fee', settings('resources.hardcopy_fee', 80)) }}"
                    step="0.01" min="0" placeholder="80.00">
            </div>

            <div class="form-group">
                <label for="resources_hardcopy_note">Note Shown to Users</label>
                <textarea name="resources_hardcopy_note" id="resources_hardcopy_note" rows="2"
                    placeholder="Printed copies are available on request.">{{ old('resources_hardcopy_note', settings('resources.hardcopy_note')) }}</textarea>
            </div>
        </div>

        {{-- ═══ BOOKS POLICY ═══ --}}
        <div class="settings-form__card">
            <div class="settings-form__card-header">
                <div class="settings-form__card-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div>
                    <h3 class="settings-form__card-title">Books Policy</h3>
                    <p class="settings-form__card-desc">Site-wide hard-copy behaviour for paid books.</p>
                </div>
            </div>

            @php
                $booksGlobalOn = (bool) settings('books.hardcopy_global_on', true);
                $booksIncludeD = (bool) settings('books.hardcopy_includes_digital', true);
            @endphp

            <div class="settings-form__checkboxes">
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="books_hardcopy_global_on" value="1"
                            {{ old('books_hardcopy_global_on', $booksGlobalOn) ? 'checked' : '' }}>
                        Enable hard-copy orders site-wide
                    </label>
                    <span class="form-help">Master switch — overrides individual book settings when off.</span>
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" name="books_hardcopy_includes_digital" value="1"
                            {{ old('books_hardcopy_includes_digital', $booksIncludeD) ? 'checked' : '' }}>
                        Hard copy always includes the digital copy
                    </label>
                    <span class="form-help">Recommended on — buyers get the file instantly plus the printed book.</span>
                </div>
            </div>
        </div>

        {{-- ─── SUBMIT ─── --}}
        <div class="books-form__actions">
            <button type="submit" class="btn btn--primary btn--lg" id="settingsSubmitBtn">
                <i class="fas fa-save"></i>
                <span class="btn-text">Save Settings</span>
                <span class="btn-loader" style="display: none;">
                    <i class="fas fa-spinner fa-spin"></i> Saving...
                </span>
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn--secondary btn--lg">Cancel</a>
        </div>
    </form>
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/admin/v150/settings.css') }}">
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('settingsForm');
        const btn = document.getElementById('settingsSubmitBtn');

        if (form && btn) {
            form.addEventListener('submit', function() {
                const txt = btn.querySelector('.btn-text');
                const loader = btn.querySelector('.btn-loader');
                const icon = btn.querySelector('i');

                btn.disabled = true;
                if (txt) txt.style.display = 'none';
                if (loader) loader.style.display = 'inline';
                if (icon) icon.style.display = 'none';
            });
        }
    });
</script>
@endpush