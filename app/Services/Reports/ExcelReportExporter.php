<?php

namespace App\Services\Reports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Facades\Excel;

class ExcelReportExporter extends AbstractReportExporter
{
    protected $exportableClass;

    protected function buildHeader(): void
    {
    }

    protected function buildBody(): void
    {
        $data = $this->data;
        $this->exportableClass = new class($data) implements FromView {
            private $data;

            public function __construct(array $data)
            {
                $this->data = $data;
            }

            public function view(): View
            {
                return view('reports.excel', $this->data);
            }
        };
    }

    protected function buildFooter(): void
    {
    }

    protected function generateFile()
    {
        return Excel::download($this->exportableClass, 'reporte-biblioteca.xlsx');
    }
}
