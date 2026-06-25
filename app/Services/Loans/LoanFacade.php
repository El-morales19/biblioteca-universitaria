<?php

namespace App\Services\Loans;

use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class LoanFacade
{
    /**
     * Centraliza el proceso de registro de un préstamo.
     *
     * @param array $data
     * @return Loan
     * @throws ValidationException
     */
    public static function createLoan(array $data): Loan
    {
        $book = Book::findOrFail($data['book_id']);
        $user = User::findOrFail($data['user_id']);

        // 1. Validar que el usuario exista, esté activo y tenga rol alumno.
        if ($user->role !== 'alumno' || !$user->active) {
            throw ValidationException::withMessages([
                'user_id' => 'El usuario seleccionado debe ser un alumno activo.'
            ]);
        }

        // 2. Validar que el libro exista, esté activo y esté disponible.
        if (!$book->active || !$book->available) {
            throw ValidationException::withMessages([
                'book_id' => 'El libro seleccionado no está disponible para préstamo.'
            ]);
        }

        // 3. Crear el registro de préstamo con status active.
        $loan = Loan::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'loan_date' => $data['loan_date'],
            'status' => 'active',
        ]);

        // 4. Actualizar el libro para marcarlo como no disponible.
        $book->update(['available' => false]);

        // 5. Retornar el préstamo creado.
        return $loan;
    }
}
