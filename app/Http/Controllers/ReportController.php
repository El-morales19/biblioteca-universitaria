<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;

class ReportController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            function ($request, $next) {
                if (!in_array(auth()->user()->role, ['admin', 'bibliotecario'])) {
                    abort(403);
                }
                return $next($request);
            }
        ];
    }

    public function index()
    {
        $totalActiveBooks = Book::where('active', true)->count();
        $availableBooks = Book::where('active', true)->where('available', true)->count();
        $unavailableBooks = Book::where('active', true)->where('available', false)->count();

        $totalLoans = Loan::count();
        $activeLoans = Loan::where('status', 'active')->count();
        $returnedLoans = Loan::where('status', 'returned')->count();

        $activeLoanUsers = User::whereHas('loans', function ($query) {
            $query->where('status', 'active');
        })->withCount(['loans' => function ($query) {
            $query->where('status', 'active');
        }])->get();

        $recentLoans = Loan::with(['user', 'book'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('reports.index', compact(
            'totalActiveBooks',
            'availableBooks',
            'unavailableBooks',
            'totalLoans',
            'activeLoans',
            'returnedLoans',
            'activeLoanUsers',
            'recentLoans'
        ));
    }
}
