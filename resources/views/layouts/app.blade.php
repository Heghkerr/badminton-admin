<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Expires" content="0">

        <title>{{ config('app.name', 'Badminton Admin') }}</title>

        <!-- PWA -->
        <meta name="theme-color" content="#16a34a">
        <link rel="manifest" href="/manifest.webmanifest">
        <link rel="icon" href="/icons/icon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/icons/icon.svg">

        <!-- Local built assets (offline-friendly) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-900">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @elseif (View::hasSection('header'))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        @yield('header')
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="pb-24 sm:pb-8">
                @if (isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </main>
        </div>
        
        <!-- CSRF Token Refresh for Mobile -->
        <script>
        // Refresh CSRF token periodically to prevent page expired on mobile
        let csrfRefreshInterval;
        
        function refreshCsrfToken() {
            fetch('{{ route("login") }}', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin'
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newToken = doc.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                if (newToken) {
                    document.querySelector('meta[name="csrf-token"]').setAttribute('content', newToken);
                    // Update all form CSRF tokens
                    document.querySelectorAll('input[name="_token"]').forEach(input => {
                        input.value = newToken;
                    });
                }
            })
            .catch(error => {
                console.log('CSRF refresh failed:', error);
            });
        }
        
        // Start refresh interval after page load
        document.addEventListener('DOMContentLoaded', function() {
            // Refresh every 30 minutes (1800000 ms)
            csrfRefreshInterval = setInterval(refreshCsrfToken, 1800000);
            
            // Clear interval when page is hidden (mobile app background)
            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    clearInterval(csrfRefreshInterval);
                } else {
                    // Refresh immediately when page becomes visible again
                    refreshCsrfToken();
                    csrfRefreshInterval = setInterval(refreshCsrfToken, 1800000);
                }
            });
            
            // Refresh on page focus (mobile tab switching)
            window.addEventListener('focus', function() {
                refreshCsrfToken();
            });
        });
        </script>

        <!-- Service Worker (PWA offline) -->
        <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').catch(() => {});
            });
        }
        </script>
    </body>
</html>
