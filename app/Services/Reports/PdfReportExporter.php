<?php

namespace App\Services\Reports;

use Barryvdh\DomPDF\Facade\Pdf;

class PdfReportExporter extends AbstractReportExporter
{
    protected $pdf;

    protected function buildHeader(): void
    {
    }

    protected function buildBody(): void
    {
        $this->pdf = Pdf::loadView('reports.pdf', $this->data);
    }

    protected function buildFooter(): void
    {
        $this->pdf->setPaper('A4', 'portrait');
    }

    protected function generateFile()
    {
        return $this->pdf->download('reporte-biblioteca.pdf');
    }
}
