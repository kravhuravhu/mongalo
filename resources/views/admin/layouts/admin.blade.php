<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin · ' . env('PROJECT_NAME', 'The Collective'))</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400;1,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ secure_asset('css/admin/admin.css') }}">
    @stack('styles')
</head>
<body>

{{-- ─── LOADING SPINNER ─── --}}
<div class="admin-loader" id="adminLoader">
    <div class="admin-loader__spinner">
        <div class="admin-loader__ring admin-loader__ring--1"></div>
        <div class="admin-loader__ring admin-loader__ring--2"></div>
        <div class="admin-loader__ring admin-loader__ring--3"></div>
        <span class="admin-loader__text">Loading...</span>
    </div>
</div>

{{-- ─── MAIN CONTENT ─── --}}
<div class="admin-wrapper" id="adminWrapper" style="display: none; opacity: 0;">
    {{-- Sidebar --}}
    @include('admin.components.sidebar')

    {{-- Main Content --}}
    <div class="admin-content">
        {{-- Top Bar --}}
        @include('admin.components.topbar')

        {{-- Page Content --}}
        <main>
            @yield('content')
        </main>
    </div>
</div>

{{-- ─── SCRIPTS ─── --}}
<script src="{{ secure_asset('js/admin.js') }}"></script>
@stack('scripts')

{{-- ─── FLASH MESSAGES ─── --}}
@if(session('success'))
    <div class="flash-message flash-message--success" id="flashMessage">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button class="flash-message__close" onclick="this.parentElement.remove()">&times;</button>
    </div>
@endif

@if(session('error'))
    <div class="flash-message flash-message--error" id="flashMessage">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button class="flash-message__close" onclick="this.parentElement.remove()">&times;</button>
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ─── HIDE LOADER WHEN PAGE FULLY LOADED ───
        const loader = document.getElementById('adminLoader');
        const wrapper = document.getElementById('adminWrapper');

        if (loader && wrapper) {
            // Show wrapper with fade in
            wrapper.style.display = 'flex';
            
            // Wait for all resources to load (images, fonts, etc)
            window.addEventListener('load', function() {
                // Fade in wrapper
                wrapper.style.transition = 'opacity 0.4s ease';
                wrapper.style.opacity = '1';
                
                // Hide loader with animation
                setTimeout(function() {
                    loader.classList.add('admin-loader--hidden');
                    setTimeout(function() {
                        loader.style.display = 'none';
                    }, 500);
                }, 400);
            });

            // Fallback: hide loader after 3 seconds even if load event doesn't fire
            setTimeout(function() {
                if (!loader.classList.contains('admin-loader--hidden')) {
                    wrapper.style.transition = 'opacity 0.4s ease';
                    wrapper.style.opacity = '1';
                    loader.classList.add('admin-loader--hidden');
                    setTimeout(function() {
                        loader.style.display = 'none';
                    }, 500);
                }
            }, 3000);
        }

        // ─── FLASH MESSAGES ───
        const flash = document.getElementById('flashMessage');
        if (flash) {
            setTimeout(function() {
                flash.classList.add('flash-message--fade-out');
                setTimeout(function() {
                    flash.remove();
                }, 400);
            }, 5000);
        }

        // ─── CONFIRM DELETE ───
        document.querySelectorAll('.delete-confirm').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                    e.preventDefault();
                }
            });
        });

        // ─── REAL-TIME SEARCH ───
        const searchInput = document.getElementById('adminSearchInput');
        const searchResults = document.getElementById('adminSearchResults');
        const searchSpinner = document.getElementById('adminSearchSpinner');
        const clearBtn = document.getElementById('adminSearchClear');

        if (searchInput && searchResults) {
            let searchTimeout = null;
            let currentQuery = searchInput.value.trim();

            // ─── PERFORM SEARCH ───
            function performSearch(query) {
                const url = new URL(window.location.href);
                const filter = url.searchParams.get('filter') || '';

                let searchUrl = window.location.pathname + '?';
                if (filter) {
                    searchUrl += 'filter=' + filter + '&';
                }
                if (query) {
                    searchUrl += 'search=' + encodeURIComponent(query);
                }

                // Show spinner
                if (searchSpinner) {
                    searchSpinner.style.display = 'inline-block';
                }

                fetch(searchUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(function(response) {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(function(data) {
                    if (data.html) {
                        searchResults.innerHTML = data.html;
                        
                        // Re-bind delete confirm on new rows
                        searchResults.querySelectorAll('.delete-confirm').forEach(function(btn) {
                            btn.addEventListener('click', function(e) {
                                if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                                    e.preventDefault();
                                }
                            });
                        });
                    }

                    if (data.total !== undefined) {
                        const countEl = document.querySelector('.books-index__filter-count');
                        if (countEl) {
                            countEl.textContent = data.total + ' books';
                        }
                    }

                    // Show/hide clear button
                    if (clearBtn) {
                        if (query.length > 0) {
                            clearBtn.style.display = 'inline-flex';
                        } else {
                            clearBtn.style.display = 'none';
                        }
                    }

                    if (searchSpinner) {
                        searchSpinner.style.display = 'none';
                    }
                })
                .catch(function(error) {
                    console.error('Search error:', error);
                    if (searchSpinner) {
                        searchSpinner.style.display = 'none';
                    }
                });
            }

            // ─── SEARCH INPUT HANDLER ───
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();

                if (searchTimeout) {
                    clearTimeout(searchTimeout);
                }

                searchTimeout = setTimeout(function() {
                    performSearch(query);
                }, 400);
            });

            // ─── CLEAR SEARCH ───
            if (clearBtn) {
                clearBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    searchInput.value = '';
                    searchInput.focus();
                    performSearch('');
                });
            }

            // ─── KEYBOARD SHORTCUTS ───
            document.addEventListener('keydown', function(e) {
                // Ctrl + / to focus search
                if ((e.ctrlKey || e.metaKey) && e.key === '/') {
                    e.preventDefault();
                    searchInput.focus();
                    searchInput.select();
                }

                // Escape to clear search
                if (e.key === 'Escape') {
                    if (document.activeElement === searchInput) {
                        searchInput.value = '';
                        searchInput.blur();
                        performSearch('');
                    }
                }
            });

            // ─── INITIAL STATE ───
            if (searchInput.value.trim().length > 0 && clearBtn) {
                clearBtn.style.display = 'inline-flex';
            }
        }

        // ─── FORM SUBMIT WITH LOADING ───
        document.querySelectorAll('.form-loading').forEach(function(form) {
            form.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    const originalText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

                    setTimeout(function() {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }, 30000);
                }
            });
        });
    });
</script>

</body>
</html>