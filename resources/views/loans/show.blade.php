<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalles del Préstamo') }}
            </h2>
            <a href="{{ route('loans.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Volver al listado') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="space-y-6">
                        <!-- Información del Préstamo -->
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                            <div>
                                <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block">{{ __('Folio de Préstamo') }}</span>
                                <span class="text-lg font-bold text-gray-900 block mt-1">#{{ $loan->id }}</span>
                            </div>
                            <div>
                                @if($loan->status === 'active')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-800">
                                        <span class="h-2 w-2 rounded-full bg-amber-500 mr-2"></span>
                                        {{ __('Préstamo Activo') }}
                                    </span>
                                @elseif($loan->status === 'returned')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <span class="h-2 w-2 rounded-full bg-green-500 mr-2"></span>
                                        {{ __('Devuelto') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                        <span class="h-2 w-2 rounded-full bg-gray-500 mr-2"></span>
                                        {{ __('Finalizado') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Información del Usuario -->
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block">{{ __('Lector / Alumno') }}</span>
                            <div class="mt-2 p-3 bg-gray-50 rounded border border-gray-100">
                                <span class="font-semibold text-gray-800 block">{{ $loan->user->name }}</span>
                                <span class="text-sm text-gray-500 block mt-0.5">{{ $loan->user->email }}</span>
                            </div>
                        </div>

                        <!-- Información del Libro -->
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block">{{ __('Libro Solicitado') }}</span>
                            <div class="mt-2 p-3 bg-gray-50 rounded border border-gray-100">
                                <span class="font-semibold text-gray-800 block">{{ $loan->book->title }}</span>
                                <span class="text-sm text-gray-600 block mt-0.5">{{ __('Autor: ') }}{{ $loan->book->author }}</span>
                                <span class="text-xs font-mono text-gray-400 block mt-1">{{ __('ISBN: ') }}{{ $loan->book->isbn }}</span>
                            </div>
                        </div>

                        <!-- Fechas -->
                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-100">
                            <div>
                                <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block">{{ __('Fecha de Salida') }}</span>
                                <span class="text-base text-gray-800 block mt-1">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d/m/Y') }}</span>
                            </div>
                            <div>
                                <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block">{{ __('Fecha de Retorno') }}</span>
                                @if($loan->return_date)
                                    <span class="text-base text-green-700 block mt-1">{{ \Carbon\Carbon::parse($loan->return_date)->format('d/m/Y') }}</span>
                                @else
                                    <span class="text-base text-gray-400 italic block mt-1">{{ __('Pendiente de devolución') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Acciones -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                            @if($loan->status === 'active')
                                <a href="{{ route('loans.edit', $loan) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Registrar Devolución') }}
                                </a>
                            @elseif($loan->status === 'returned')
                                <div class="text-sm text-gray-500 italic">
                                    {{ __('Este préstamo fue devuelto exitosamente.') }}
                                </div>
                            @else
                                <div class="text-sm text-gray-500 italic">
                                    {{ __('Este préstamo ha sido finalizado.') }}
                                </div>
                            @endif

                            @if($loan->status !== 'finalizado')
                                <!-- Acción secundaria de finalización -->
                                <form action="{{ route('loans.destroy', $loan) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que deseas finalizar este préstamo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-500 hover:text-red-700 hover:underline transition duration-150">
                                        {{ __('Finalizar préstamo') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
