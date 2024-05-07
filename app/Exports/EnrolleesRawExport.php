<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EnrolleesRawExport implements FromArray, WithHeadings
{

    public $enrollees, $headingRow;

    public function __construct($enrollees, $headingRow)
    {
        $this->enrollees = $enrollees;
        $this->headingRow = $headingRow;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        return $this->enrollees;
    }

    public function headings(): array
    {
        return $this->headingRow;
    }
}
