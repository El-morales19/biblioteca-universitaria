<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Reportes y Estadísticas') }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('reports.exportPdf') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Exportar PDF') }}
                </a>
                <a href="{{ route('reports.exportExcel') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Exportar Excel') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 {{ $isStudentReport ? 'md:grid-cols-4 lg:grid-cols-4' : 'md:grid-cols-3 lg:grid-cols-6' }} gap-6 mb-8">
                @if(!$isStudentReport)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wider block">{{ __('Total Libros') }}</span>
                        <span class="text-3xl font-bold text-gray-900 block mt-2">{{ $totalActiveBooks }}</span>
                    </div>
                @endif

                @if(!$isStudentReport)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wider block text-green-600">{{ __('Libros Disponibles') }}</span>
                        <span class="text-3xl font-bold text-green-700 block mt-2">{{ $availableBooks }}</span>
                    </div>
                @endif

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6">
                    <span class="text-xs text-gray-500 font-semibold uppercase tracking-wider block text-red-600">
                        {{ $isStudentReport ? __('Libros en Préstamo Activo') : __('Libros Prestados') }}
                    </span>
                    <span class="text-3xl font-bold text-red-700 block mt-2">{{ $unavailableBooks }}</span>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6">
                    <span class="text-xs text-gray-500 font-semibold uppercase tracking-wider block">{{ __('Total Préstamos') }}</span>
                    <span class="text-3xl font-bold text-gray-900 block mt-2">{{ $totalLoans }}</span>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6">
                    <span class="text-xs text-gray-500 font-semibold uppercase tracking-wider block text-amber-600">{{ __('Préstamos Activos') }}</span>
                    <span class="text-3xl font-bold text-amber-700 block mt-2">{{ $activeLoans }}</span>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6">
                    <span class="text-xs text-gray-500 font-semibold uppercase tracking-wider block text-blue-600">{{ __('Préstamos Finalizados') }}</span>
                    <span class="text-3xl font-bold text-blue-700 block mt-2">{{ $returnedLoans }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">{{ __('Últimos 10 Préstamos') }}</h3>
                    @if($recentLoans->isEmpty())
                        <div class="text-center py-6 text-gray-500 text-sm">
                            {{ __('No hay préstamos registrados.') }}
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Usuario') }}</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Libro') }}</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Fechas') }}</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Estado') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 text-xs text-gray-700">
                                    @foreach($recentLoans as $loan)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-4 py-4">
                                                <div class="font-semibold">{{ $loan->user->name }}</div>
                                                <div class="text-gray-400">{{ $loan->user->email }}</div>
                                            </td>
                                            <td class="px-4 py-4">
                                                <div class="font-semibold">{{ $loan->book->title }}</div>
                                                <div class="text-gray-400">ISBN: {{ $loan->book->isbn }}</div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div>{{ __('Salida: ') }}{{ \Carbon\Carbon::parse($loan->loan_date)->format('d/m/Y') }}</div>
                                                <div class="mt-0.5">
                                                    {{ __('Retorno: ') }}
                                                    @if($loan->return_date)
                                                        {{ \Carbon\Carbon::parse($loan->return_date)->format('d/m/Y') }}
                                                    @else
                                                        <span class="text-amber-600 font-medium">{{ __('Pendiente') }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                @if($loan->status === 'active')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                                        {{ __('Activo') }}
                                                    </span>
                                                @elseif($loan->status === 'returned')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        {{ __('Devuelto') }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        {{ __('Finalizado') }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6">
                    @if($isStudentReport)
                        <h3 class="text-lg font-bold text-gray-900 mb-6">{{ __('Libros con préstamo activo') }}</h3>
                        @if($activeLoanBooks->isEmpty())
                            <div class="text-center py-6 text-gray-500 text-sm">
                                {{ __('No tienes libros con préstamo activo actualmente.') }}
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Libro') }}</th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Autor') }}</th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Fecha Préstamo') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200 text-xs text-gray-700">
                                        @foreach($activeLoanBooks as $loan)
                                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                <td class="px-4 py-4 whitespace-nowrap font-medium text-gray-900">
                                                    {{ $loan->book->title }}
                                                    <div class="text-xs text-gray-400">ISBN: {{ $loan->book->isbn }}</div>
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap text-gray-500">
                                                    {{ $loan->book->author }}
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap text-gray-600">
                                                    {{ \Carbon\Carbon::parse($loan->loan_date)->format('d/m/Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @else
                        <h3 class="text-lg font-bold text-gray-900 mb-6">{{ __('Usuarios con préstamos activos') }}</h3>
                        @if($activeLoanUsers->isEmpty())
                            <div class="text-center py-6 text-gray-500 text-sm">
                                {{ __('No hay usuarios con préstamos activos.') }}
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Nombre') }}</th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Email') }}</th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Préstamos Activos') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200 text-xs text-gray-700">
                                        @foreach($activeLoanUsers as $user)
                                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                <td class="px-4 py-4 whitespace-nowrap font-medium text-gray-900">
                                                    {{ $user->name }}
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap text-gray-500">
                                                    {{ $user->email }}
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                                        {{ $user->loans_count }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
