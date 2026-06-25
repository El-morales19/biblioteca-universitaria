<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    $data = [];
    
    if ($user->role === 'admin') {
        $data['totalUsers'] = \App\Models\User::where('active', true)->count();
        $data['totalBooks'] = \App\Models\Book::where('active', true)->count();
        $data['activeLoans'] = \App\Models\Loan::where('status', 'active')->count();
        $data['returnedLoans'] = \App\Models\Loan::where('status', 'returned')->count();
    } elseif ($user->role === 'bibliotecario') {
        $data['availableBooks'] = \App\Models\Book::where('active', true)->where('available', true)->count();
        $data['loanedBooks'] = \App\Models\Book::where('active', true)->where('available', false)->count();
        $data['activeLoans'] = \App\Models\Loan::where('status', 'active')->count();
    } elseif ($user->role === 'alumno') {
        $data['totalPersonalLoans'] = \App\Models\Loan::where('user_id', $user->id)->count();
        $data['activePersonalLoans'] = \App\Models\Loan::where('user_id', $user->id)->where('status', 'active')->count();
        $data['booksInPossession'] = \App\Models\Loan::where('user_id', $user->id)->where('status', 'active')->count();
    }

    return view('dashboard', $data);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/books/inactive', [BookController::class, 'inactive'])->name('books.inactive');
    Route::patch('/books/{book}/reactivate', [BookController::class, 'reactivate'])->name('books.reactivate');
    Route::resource('books', BookController::class);
    Route::resource('loans', LoanController::class);
    Route::get('/users/inactive', [UserController::class, 'inactive'])->name('users.inactive');
    Route::patch('/users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::resource('users', UserController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.exportPdf');
    Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.exportExcel');
});

require __DIR__.'/auth.php';