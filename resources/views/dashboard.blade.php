<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Bienvenido, {{ auth()->user()->name }}</h3>
            
            @if(auth()->user()->role === 'admin')
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wider block">Total Usuarios Activos</span>
                        <span class="text-3xl font-bold text-gray-900 block mt-2">{{ $totalUsers }}</span>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wider block">Total Libros Activos</span>
                        <span class="text-3xl font-bold text-gray-900 block mt-2">{{ $totalBooks }}</span>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wider block text-amber-600">Préstamos Activos</span>
                        <span class="text-3xl font-bold text-amber-700 block mt-2">{{ $activeLoans }}</span>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wider block text-blue-600">Préstamos Finalizados</span>
                        <span class="text-3xl font-bold text-blue-700 block mt-2">{{ $returnedLoans }}</span>
                    </div>
                </div>
            @elseif(auth()->user()->role === 'bibliotecario')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wider block text-green-600">Libros Disponibles</span>
                        <span class="text-3xl font-bold text-green-700 block mt-2">{{ $availableBooks }}</span>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wider block text-red-600">Libros Prestados</span>
                        <span class="text-3xl font-bold text-red-700 block mt-2">{{ $loanedBooks }}</span>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wider block text-amber-600">Préstamos Activos</span>
                        <span class="text-3xl font-bold text-amber-700 block mt-2">{{ $activeLoans }}</span>
                    </div>
                </div>
            @elseif(auth()->user()->role === 'alumno')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wider block">Total Préstamos Personales</span>
                        <span class="text-3xl font-bold text-gray-900 block mt-2">{{ $totalPersonalLoans }}</span>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wider block text-amber-600">Préstamos Activos</span>
                        <span class="text-3xl font-bold text-amber-700 block mt-2">{{ $activePersonalLoans }}</span>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wider block text-red-600">Libros en Posesión</span>
                        <span class="text-3xl font-bold text-red-700 block mt-2">{{ $booksInPossession }}</span>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
