<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class LoanController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(function ($request, $next) {
                if (!in_array(auth()->user()->role, ['admin', 'bibliotecario'])) {
                    abort(403);
                }
                return $next($request);
            }, except: ['index', 'show'])
        ];
    }

    public function index()
    {
        $query = Loan::with(['user', 'book'])->orderBy('created_at', 'desc');

        if (auth()->user()->role === 'alumno') {
            $query->where('user_id', auth()->id());
        }

        $loans = $query->get();
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $books = Book::where('active', true)->where('available', true)->get();
        $users = User::where('role', 'alumno')
            ->where('active', true)
            ->orderBy('name')
            ->get();
        return view('loans.create', compact('books', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
        ]);

        \App\Services\Loans\LoanFacade::createLoan($validated);

        return redirect()->route('loans.index')->with('success', 'Préstamo registrado exitosamente.');
    }

    public function show(Loan $loan)
    {
        if (auth()->user()->role === 'alumno' && $loan->user_id !== auth()->id()) {
            abort(403);
        }

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

            // Disparar evento para que el Mediator (Event Dispatcher) se encargue de notificar
            \App\Events\BookReturned::dispatch($loan, $loan->user, $loan->book, $loan->return_date);
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
