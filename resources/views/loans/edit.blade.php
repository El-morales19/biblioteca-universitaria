<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Devolución') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 border-b border-gray-100 pb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Resumen del Préstamo Activo') }}</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block">{{ __('Usuario / Alumno') }}</span>
                                <span class="text-base text-gray-900 block mt-0.5">{{ $loan->user->name }} ({{ $loan->user->email }})</span>
                            </div>
                            
                            <div>
                                <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block">{{ __('Libro Prestado') }}</span>
                                <span class="text-base text-gray-900 block mt-0.5">{{ $loan->book->title }} (ISBN: {{ $loan->book->isbn }})</span>
                            </div>
                            
                            <div>
                                <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block">{{ __('Fecha de Salida') }}</span>
                                <span class="text-base text-gray-900 block mt-0.5">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('loans.update', $loan) }}">
                        @csrf
                        @method('PATCH')

                        <!-- Estado oculto o visible -->
                        <div class="mb-6">
                            <span class="text-sm text-gray-600 block mb-2">
                                {{ __('Al registrar la devolución, el libro quedará inmediatamente disponible para nuevos préstamos y se registrará la fecha de hoy como fecha de retorno.') }}
                            </span>
                            <input type="hidden" name="status" value="returned">
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('loans.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Cancelar') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Confirmar Devolución') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
