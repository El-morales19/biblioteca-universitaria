<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Nuevo Préstamo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('loans.store') }}">
                        @csrf

                        <!-- Seleccionar Alumno -->
                        <div>
                            <x-input-label for="user_id" :value="__('Alumno')" />
                            <x-text-input id="user_search" class="block mt-1 w-full" type="text" placeholder="{{ __('Buscar alumno por nombre o correo...') }}" />
                            <select id="user_id" name="user_id" class="block mt-2 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus>
                                <option value="" disabled selected>{{ __('Seleccione un alumno') }}</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" data-name="{{ strtolower($user->name) }}" data-email="{{ strtolower($user->email) }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                        </div>

                        <!-- Seleccionar Libro -->
                        <div class="mt-4">
                            <x-input-label for="book_id" :value="__('Libro Disponible')" />
                            <select id="book_id" name="book_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="" disabled selected>{{ __('Seleccione un libro') }}</option>
                                @foreach($books as $book)
                                    <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                        {{ $book->title }} - {{ $book->author }} (ISBN: {{ $book->isbn }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('book_id')" class="mt-2" />
                        </div>

                        <!-- Fecha de Préstamo -->
                        <div class="mt-4">
                            <x-input-label for="loan_date" :value="__('Fecha de Préstamo')" />
                            <x-text-input id="loan_date" class="block mt-1 w-full" type="date" name="loan_date" :value="old('loan_date', date('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('loan_date')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-3">
                            <a href="{{ route('loans.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button>
                                {{ __('Registrar Préstamo') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('user_search');
            const select = document.getElementById('user_id');
            const originalOptions = Array.from(select.options);

            searchInput.addEventListener('input', function () {
                const query = searchInput.value.toLowerCase().trim();
                originalOptions.forEach(option => {
                    if (option.disabled) {
                        return;
                    }
                    const name = option.getAttribute('data-name') || '';
                    const email = option.getAttribute('data-email') || '';
                    if (name.includes(query) || email.includes(query)) {
                        option.hidden = false;
                        option.style.display = '';
                    } else {
                        option.hidden = true;
                        option.style.display = 'none';
                    }
                });
            });
        });
    </script>
</x-app-layout>
