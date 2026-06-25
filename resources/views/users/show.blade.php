<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalles del Usuario') }}
            </h2>
            <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Volver al listado') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="space-y-6">
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block">{{ __('Nombre') }}</span>
                            <span class="text-lg font-bold text-gray-900 block mt-1">{{ $user->name }}</span>
                        </div>

                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block">{{ __('Email') }}</span>
                            <span class="text-base text-gray-800 block mt-1">{{ $user->email }}</span>
                        </div>

                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block">{{ __('Rol') }}</span>
                            <div class="mt-1">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-indigo-100 text-indigo-800 uppercase tracking-wider">
                                    {{ $user->role }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block">{{ __('Estado de Cuenta') }}</span>
                            <div class="mt-2">
                                @if($user->active)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <span class="h-2 w-2 rounded-full bg-green-500 mr-2"></span>
                                        {{ __('Cuenta Activa') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        <span class="h-2 w-2 rounded-full bg-red-500 mr-2"></span>
                                        {{ __('Cuenta Inactiva') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-100 text-xs text-gray-500">
                            <div>
                                <span>{{ __('Registrado el:') }}</span>
                                <span class="font-medium text-gray-700 block mt-0.5">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div>
                                <span>{{ __('Última actualización:') }}</span>
                                <span class="font-medium text-gray-700 block mt-0.5">{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                            @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas dar de baja a este usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 hover:text-red-700 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150">
                                        {{ __('Dar de baja') }}
                                    </button>
                                </form>
                            @else
                                <div class="text-xs text-gray-400 italic">
                                    {{ __('No puedes dar de baja a tu propia cuenta activa.') }}
                                </div>
                            @endif

                            <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center px-4 py-2 bg-amber-50 hover:bg-amber-100 text-amber-600 hover:text-amber-700 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150">
                                {{ __('Editar información') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
