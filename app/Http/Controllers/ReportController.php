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
                if (!in_array(auth()->user()->role, ['admin', 'bibliotecario', 'alumno'])) {
                    abort(403);
                }
                return $next($request);
            }
        ];
    }

    public function index()
    {
        $role = auth()->user()->role;
        $isStudentReport = ($role === 'alumno');

        if ($isStudentReport) {
            $totalActiveBooks = null;
            $availableBooks = null;
            $unavailableBooks = Loan::where('user_id', auth()->id())->where('status', 'active')->count();

            $totalLoans = Loan::where('user_id', auth()->id())->count();
            $activeLoans = Loan::where('user_id', auth()->id())->where('status', 'active')->count();
            $returnedLoans = Loan::where('user_id', auth()->id())->where('status', 'returned')->count();

            $activeLoanUsers = null;
            $activeLoanBooks = Loan::where('user_id', auth()->id())
                ->where('status', 'active')
                ->with('book')
                ->get();

            $recentLoans = Loan::where('user_id', auth()->id())
                ->with(['user', 'book'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        } else {
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

            $activeLoanBooks = null;

            $recentLoans = Loan::with(['user', 'book'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        }

        return view('reports.index', compact(
            'totalActiveBooks',
            'availableBooks',
            'unavailableBooks',
            'totalLoans',
            'activeLoans',
            'returnedLoans',
            'activeLoanUsers',
            'activeLoanBooks',
            'recentLoans',
            'isStudentReport'
        ));
    }
}
