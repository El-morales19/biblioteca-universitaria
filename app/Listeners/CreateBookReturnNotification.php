<?php

namespace App\Listeners;

use App\Events\BookReturned;
use App\Notifications\BookReturnedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class CreateBookReturnNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BookReturned $event): void
    {
        // El Event Dispatcher llama a este método.
        // Usamos Notification::send para crear el registro en la base de datos.
        Notification::send($event->user, new BookReturnedNotification($event->book, $event->date));
    }
}
