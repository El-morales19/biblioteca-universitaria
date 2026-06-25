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

    public function index(\App\Services\Reports\ReportDataBuilder $builder)
    {
        $data = $builder->build(auth()->user());
        return view('reports.index', $data);
    }

    public function exportPdf(\App\Services\Reports\ReportDataBuilder $builder, \App\Services\Reports\PdfReportExporter $exporter)
    {
        $data = $builder->build(auth()->user());
        return $exporter->export($data);
    }

    public function exportExcel(\App\Services\Reports\ReportDataBuilder $builder, \App\Services\Reports\ExcelReportExporter $exporter)
    {
        $data = $builder->build(auth()->user());
        return $exporter->export($data);
    }
}
