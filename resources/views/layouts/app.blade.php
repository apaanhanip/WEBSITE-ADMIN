<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/coko-logo.svg') }}">
    <title>@yield('title', 'Dashboard') — CŌKO Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    </script>
</head>
<body class="min-h-screen bg-cream-50">
    <div class="flex min-h-screen">
        @include('components.sidebar')

        <div class="flex flex-1 flex-col lg:pl-64">
            @include('components.navbar')

            <main class="flex-1 animate-fade-in p-4 sm:p-6 lg:p-8">
                @include('components.alert')
                @yield('content')
            </main>
        </div>
    </div>

    @stack('modals')
    @stack('scripts')

    @if(session('success'))
    <script>Toast.fire({ icon: 'success', title: @json(session('success')) });</script>
    @endif
    @if(session('error'))
    <script>Toast.fire({ icon: 'error', title: @json(session('error')) });</script>
    @endif
</body>
</html>
