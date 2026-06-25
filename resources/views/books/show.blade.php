<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalles del Libro') }}
            </h2>
            <a href="{{ route('books.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Volver al catálogo') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="space-y-6">
                        <!-- Título -->
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block">{{ __('Título') }}</span>
                            <span class="text-lg font-bold text-gray-900 block mt-1">{{ $book->title }}</span>
                        </div>

                        <!-- Autor -->
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block">{{ __('Autor') }}</span>
                            <span class="text-base text-gray-800 block mt-1">{{ $book->author }}</span>
                        </div>

                        <!-- ISBN -->
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block">{{ __('ISBN') }}</span>
                            <span class="text-base font-mono text-gray-700 block mt-1">{{ $book->isbn }}</span>
                        </div>

                        <!-- Disponibilidad -->
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block">{{ __('Disponibilidad') }}</span>
                            <div class="mt-2">
                                @if($book->available)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <span class="h-2 w-2 rounded-full bg-green-500 mr-2"></span>
                                        {{ __('Disponible para préstamo') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        <span class="h-2 w-2 rounded-full bg-red-500 mr-2"></span>
                                        {{ __('Prestado / No disponible') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Fechas -->
                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-100 text-xs text-gray-500">
                            <div>
                                <span>{{ __('Registrado el:') }}</span>
                                <span class="font-medium text-gray-700 block mt-0.5">{{ $book->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div>
                                <span>{{ __('Última actualización:') }}</span>
                                <span class="font-medium text-gray-700 block mt-0.5">{{ $book->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>

                        @if(in_array(auth()->user()->role, ['admin', 'bibliotecario']))
                        <div class="flex items-center justify-between pt-6 border-t border-gray-100 space-x-3">
                            <form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas dar de baja este libro?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 hover:text-red-700 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150">
                                    {{ __('Dar de baja') }}
                                </button>
                            </form>

                            <a href="{{ route('books.edit', $book) }}" class="inline-flex items-center px-4 py-2 bg-amber-50 hover:bg-amber-100 text-amber-600 hover:text-amber-700 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150">
                                {{ __('Editar información') }}
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
