<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Libro') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('books.update', $book) }}">
                        @csrf
                        @method('PATCH')

                        <!-- Título -->
                        <div>
                            <x-input-label for="title" :value="__('Título del Libro')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $book->title)" required autofocus autocomplete="title" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Autor -->
                        <div class="mt-4">
                            <x-input-label for="author" :value="__('Autor')" />
                            <x-text-input id="author" class="block mt-1 w-full" type="text" name="author" :value="old('author', $book->author)" required autocomplete="author" />
                            <x-input-error :messages="$errors->get('author')" class="mt-2" />
                        </div>

                        <!-- ISBN -->
                        <div class="mt-4">
                            <x-input-label for="isbn" :value="__('ISBN')" />
                            <x-text-input id="isbn" class="block mt-1 w-full" type="text" name="isbn" :value="old('isbn', $book->isbn)" required autocomplete="isbn" />
                            <x-input-error :messages="$errors->get('isbn')" class="mt-2" />
                        </div>

                        <!-- Disponible -->
                        <div class="block mt-6">
                            <label for="available" class="inline-flex items-center">
                                <input id="available" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="available" value="1" {{ old('available', $book->available) ? 'checked' : '' }}>
                                <span class="ms-2 text-sm text-gray-600">{{ __('Disponible para préstamo') }}</span>
                            </label>
                            <x-input-error :messages="$errors->get('available')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-3">
                            <a href="{{ route('books.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button>
                                {{ __('Actualizar Libro') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
