<x-guest-layout>
    <div class="mb-4 text-center">
        <svg class="mx-auto h-16 w-16 text-red-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">
            {{ __('Cuenta Desactivada') }}
        </h2>
        <p class="text-gray-600 text-md">
            {{ __('Tu cuenta ha sido desactivada temporal o permanentemente. Si crees que esto es un error o necesitas reactivar tu acceso, por favor contacta a la administración de la biblioteca universitaria.') }}
        </p>
    </div>

    <div class="mt-8 flex justify-center">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Entendido, Cerrar Sesión') }}
            </button>
        </form>
    </div>
</x-guest-layout>
