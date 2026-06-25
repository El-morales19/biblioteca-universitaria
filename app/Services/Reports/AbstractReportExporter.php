<?php

namespace App\Services\Reports;

abstract class AbstractReportExporter
{
    protected $data;

    final public function export(array $data)
    {
        $this->prepareData($data);
        $this->buildHeader();
        $this->buildBody();
        $this->buildFooter();
        return $this->generateFile();
    }

    protected function prepareData(array $data): void
    {
        $this->data = $data;
    }

    abstract protected function buildHeader(): void;
    abstract protected function buildBody(): void;
    abstract protected function buildFooter(): void;
    abstract protected function generateFile();
}
