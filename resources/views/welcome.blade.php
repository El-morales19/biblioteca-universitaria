<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Biblioteca Universitaria') }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans">
    <div class="relative min-h-screen bg-gray-900 overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/library-bg.jpeg') }}" alt="Library Background" class="w-full h-full object-cover opacity-30" />
            <div class="absolute inset-0 bg-gray-900/60 mix-blend-multiply"></div>
        </div>

        <!-- Navigation / Header -->
        <div class="relative z-10 flex items-center justify-between p-6 lg:px-8">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-10 object-contain" />
                <span class="text-white font-bold text-xl tracking-tight hidden sm:block">{{ config('app.name', 'Biblioteca Universitaria') }}</span>
            </div>
            @if (Route::has('login'))
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-white hover:text-indigo-300 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-white hover:text-indigo-300 transition">Iniciar sesión</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm font-semibold text-white hover:text-indigo-300 transition">Registrarse</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 flex flex-col items-center justify-center min-h-[80vh] px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight mb-4">
                Biblioteca Universitaria
            </h1>
            <p class="text-xl sm:text-2xl text-indigo-300 font-medium mb-8 max-w-2xl">
                Sistema de Gestión Bibliotecaria
            </p>
            <p class="text-base sm:text-lg text-gray-300 mb-10 max-w-3xl leading-relaxed">
                Plataforma integral para la administración eficiente de usuarios, catálogo de libros, control de préstamos, devoluciones y reportes estadísticos.
            </p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-12 w-full max-w-5xl">
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-xl flex flex-col items-center hover:bg-white/20 transition duration-300 cursor-default">
                    <span class="text-white font-medium text-lg">Gestión de usuarios</span>
                </div>
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-xl flex flex-col items-center hover:bg-white/20 transition duration-300 cursor-default">
                    <span class="text-white font-medium text-lg">Catálogo de libros</span>
                </div>
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-xl flex flex-col items-center hover:bg-white/20 transition duration-300 cursor-default">
                    <span class="text-white font-medium text-lg">Préstamos y devoluciones</span>
                </div>
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-xl flex flex-col items-center hover:bg-white/20 transition duration-300 cursor-default">
                    <span class="text-white font-medium text-lg">Reportes y estadísticas</span>
                </div>
            </div>

            @if (!Auth::check())
                <a href="{{ route('login') }}" class="rounded-md bg-indigo-600 px-8 py-3 text-lg font-semibold text-white shadow-lg hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition transform hover:-translate-y-1">
                    Acceder al Sistema
                </a>
            @endif
        </div>
    </div>
</body>
</html>
