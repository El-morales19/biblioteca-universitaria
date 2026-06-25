<?php

namespace App\Services\Reports;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;

class ReportDataBuilder
{
    public function build($user)
    {
        $role = $user->role;
        $isStudentReport = ($role === 'alumno');

        $data = [
            'isStudentReport' => $isStudentReport,
        ];

        if ($isStudentReport) {
            $data['totalActiveBooks'] = null;
            $data['availableBooks'] = null;
            $data['unavailableBooks'] = Loan::where('user_id', $user->id)->where('status', 'active')->count();

            $data['totalLoans'] = Loan::where('user_id', $user->id)->count();
            $data['activeLoans'] = Loan::where('user_id', $user->id)->where('status', 'active')->count();
            $data['returnedLoans'] = Loan::where('user_id', $user->id)->where('status', 'returned')->count();

            $data['activeLoanUsers'] = null;
            $data['activeLoanBooks'] = Loan::where('user_id', $user->id)
                ->where('status', 'active')
                ->with('book')
                ->get();

            $data['recentLoans'] = Loan::where('user_id', $user->id)
                ->with(['user', 'book'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        } else {
            $data['totalActiveBooks'] = Book::where('active', true)->count();
            $data['availableBooks'] = Book::where('active', true)->where('available', true)->count();
            $data['unavailableBooks'] = Book::where('active', true)->where('available', false)->count();

            $data['totalLoans'] = Loan::count();
            $data['activeLoans'] = Loan::where('status', 'active')->count();
            $data['returnedLoans'] = Loan::where('status', 'returned')->count();

            $data['activeLoanUsers'] = User::whereHas('loans', function ($query) {
                $query->where('status', 'active');
            })->withCount(['loans' => function ($query) {
                $query->where('status', 'active');
            }])->get();

            $data['activeLoanBooks'] = null;

            $data['recentLoans'] = Loan::with(['user', 'book'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        }

        return $data;
    }
}
