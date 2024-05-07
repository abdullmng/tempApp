<?php

namespace App\Imports;

use App\Models\Enrollee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EnrolleesRawImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return  new Enrollee([
            'reference' => $row['reference'],
            'branch_id' => $row['branch_id'],
            'sector_id' => $row['sector_id'],
            'organisation_id' => $row['organisation_id'],
            'hcp_id' => $row['hcp_id'],
            'category_id' => $row['category_id'],
            'pf_number' => $row['pf_number'],
            'first_name' => strtoupper($row['first_name']),
            'middle_name' => strtoupper($row['middle_name']),
            'last_name' => strtoupper($row['last_name']),
            'gender' => $row['gender'],
            'date_of_birth' => $row['date_of_birth'],
            'email' => $row['email'],
            'phone_number' => $row['phone_number'],
            'address' => $row['address'],
            'nin' => $row['nin'],
            'marital_status' => $row['marital_status'],
            'picture' => $row['picture'],
            'blood_group_id' => $row['blood_group_id'],
            'illness' => $row['illness'],
            'date_of_first_appointment' => $row['date_of_first_appointment'],
            'occupation' => $row['occupation'],
            'designation' => $row['designation'],
            'station' => $row['station'],
            'hmo_id' => $row['hmo_id'],
            'hmo' => $row['hmo'],
            'enrolled_by' => $row['enrolled_by'] 
        ]);
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 5000;
    }
}
