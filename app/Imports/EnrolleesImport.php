<?php

namespace App\Imports;

use App\Models\Enrollee;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EnrolleesImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $new_dob = !is_null($row['date_of_birth']) ? str_replace('/', '-', $row['date_of_birth']) : '00-00-0000';
        $dob = Carbon::parse($row['date_of_birth'])->format('Y-m-d');//Carbon::createFromFormat('d-m-Y', $new_dob)->format('Y-m-d');
        $reference = !is_null($row["refrence"]) ? $row["refrence"] : $this->generateReference($row, $dob);
        $email = !is_null($row['email']) ? $row['email'] : $reference.'@fhis.com';
        return new Enrollee([
            'reference' => $reference,
            'branch_id' => null,
            'sector_id' => null,
            'organisation_id' => null,
            'hcp_id' => null,
            'category_id' => null,
            'pf_number' => $row['pf_number'],
            'first_name' => strtoupper($row['first_name']),
            'middle_name' => strtoupper($row['middle_name']),
            'last_name' => strtoupper($row['last_name']),
            'gender' => $row['gender'],
            'date_of_birth' => $dob,
            'email' => $email,
            'phone_number' => $row['phone_number'],
            'address' => $row['address'],
            'nin' => $row['nin'],
            'marital_status' => $row['marital_status'],
            'picture' => $row['picture'],
            'blood_group_id' => null,
            'illness' => $row['illness'],
            'date_of_first_appointment' => $row['date_of_first_appointment'],
            'occupation' => $row['occupation'],
            'designation' => $row['designation'],
            'station' => $row['station'],
            'hmo' => $row['hmo'],
            'enrolled_by' => auth()->id() 
        ]);
    }

    protected function generateReferenceWithDob($row, $dob)
    {
        $year = Carbon::now()->year;
        $dob = Carbon::parse($dob);
        $yob = $dob->format('Y');
        $age = $year - intval($yob);
        $first_name_char = substr($row['first_name'],0,1);
        $last_name_char = substr($row['last_name'], 0, 1);
        $dob_append = str_replace('-','', $dob);
        $arr = [0,1];
        $reference = strtoupper($first_name_char.$last_name_char). substr($age,$arr[array_rand($arr, 1)], 1). $dob_append . substr($age,$arr[array_rand($arr, 1)], 1);
        return $reference;
    }

    protected function generateReference($row, $dob)
    {
        $first_name_char = substr($row['first_name'],0,1);
        $last_name_char = substr($row['last_name'], 0, 1);
        $random_number = mt_rand(10000000, 99999999);
        $reference = $this->generateReferenceWithDob($row, $dob);
        if (Enrollee::where('reference', $reference)->exists())
        {
            $reference = strtoupper($first_name_char.$last_name_char). $random_number;
            if (Enrollee::where('reference', $reference)->exists())
            {
                return $this->generateReference($row, $dob);
            }
        }
        return $reference;
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
