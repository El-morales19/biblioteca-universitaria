<?php

namespace App\Notifications;

use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookReturnedNotification extends Notification
{
    use Queueable;

    protected $book;
    protected $date;

    /**
     * Create a new notification instance.
     */
    public function __construct(Book $book, string $date)
    {
        $this->book = $book;
        $this->date = $date;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Forzar el almacenamiento solo en base de datos
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Libro devuelto correctamente',
            'message' => 'Has devuelto el libro "' . $this->book->title . '" el día ' . $this->date . '.',
            'book_id' => $this->book->id,
            'date' => $this->date,
        ];
    }
}
