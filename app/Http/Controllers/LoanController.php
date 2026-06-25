<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['user', 'book'])->orderBy('created_at', 'desc')->get();
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $books = Book::where('active', true)->where('available', true)->get();
        $users = User::all();
        return view('loans.create', compact('books', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
        ]);

        $book = Book::findOrFail($request->book_id);

        if (!$book->active || !$book->available) {
            return back()
                ->withErrors(['book_id' => 'El libro seleccionado no está disponible para préstamo.'])
                ->withInput();
        }

        Loan::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'loan_date' => $request->loan_date,
            'status' => 'active',
        ]);

        $book->update(['available' => false]);

        return redirect()->route('loans.index')->with('success', 'Préstamo registrado exitosamente.');
    }

    public function show(Loan $loan)
    {
        $loan->load(['user', 'book']);
        return view('loans.show', compact('loan'));
    }

    public function edit(Loan $loan)
    {
        $loan->load(['user', 'book']);
        return view('loans.edit', compact('loan'));
    }

    public function update(Request $request, Loan $loan)
    {
        $request->validate([
            'status' => 'required|in:active,returned,finalizado',
        ]);

        if ($request->status === 'returned' && $loan->status === 'active') {
            $loan->update([
                'status' => 'returned',
                'return_date' => now()->toDateString(),
            ]);

            $loan->book->update(['available' => true]);
        }

        return redirect()->route('loans.index')->with('success', 'Préstamo actualizado y devuelto exitosamente.');
    }

    public function destroy(Loan $loan)
    {
        if ($loan->status === 'active') {
            $loan->book->update(['available' => true]);
        }

        $loan->update([
            'status' => 'finalizado',
            'return_date' => $loan->return_date ?? now()->toDateString(),
        ]);

        return redirect()->route('loans.index')->with('success', 'El préstamo ha sido finalizado correctamente.');
    }
}
