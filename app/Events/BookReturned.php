<?php

namespace App\Events;

use App\Models\Loan;
use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookReturned
{
    use Dispatchable, SerializesModels;

    public $loan;
    public $user;
    public $book;
    public $date;

    /**
     * Create a new event instance.
     */
    public function __construct(Loan $loan, User $user, Book $book, string $date)
    {
        $this->loan = $loan;
        $this->user = $user;
        $this->book = $book;
        $this->date = $date;
    }
}
