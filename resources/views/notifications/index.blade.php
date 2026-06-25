<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notificaciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($notifications->isEmpty())
                        <p class="text-gray-500 text-center py-8">{{ __('No tienes notificaciones por el momento.') }}</p>
                    @else
                        <div class="space-y-4">
                            @foreach($notifications as $notification)
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 border rounded-lg {{ $notification->read_at ? 'bg-gray-50 border-gray-200' : 'bg-blue-50 border-blue-200 shadow-sm' }}">
                                    <div class="mb-4 sm:mb-0">
                                        <h4 class="font-bold text-lg {{ $notification->read_at ? 'text-gray-700' : 'text-blue-900' }}">
                                            {{ $notification->data['title'] }}
                                        </h4>
                                        <p class="text-gray-600 mt-1">{{ $notification->data['message'] }}</p>
                                        <p class="text-xs text-gray-500 mt-2 font-medium">{{ $notification->created_at->translatedFormat('d M Y, h:i a') }} ({{ $notification->created_at->diffForHumans() }})</p>
                                    </div>
                                    
                                    @if(is_null($notification->read_at))
                                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-sm px-4 py-2 bg-white shadow-sm border border-gray-300 rounded-md hover:bg-gray-50 text-gray-700 font-medium transition">
                                                {{ __('Marcar como leída') }}
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-sm text-green-600 flex items-center font-medium">
                                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Leída
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
