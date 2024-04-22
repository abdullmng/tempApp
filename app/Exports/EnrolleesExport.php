<?php

namespace App\Exports;

use App\Models\Enrollee;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EnrolleesExport implements FromArray, WithHeadings
{
    protected $enrollees, $headings;

    public function __construct(array $enrollees, array $headings)
    {
        $this->enrollees = $enrollees;
        $this->headings = $headings;
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
        return $this->headings;
    }
}
