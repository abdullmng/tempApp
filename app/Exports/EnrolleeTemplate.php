<?php

namespace App\Exports;

use App\Models\Enrollee;
use Maatwebsite\Excel\Concerns\FromCollection;

class EnrolleeTemplate implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            [
                'reference' => 'refrence',
                'branch' => 'branch',
                'sector' => 'sector',
                'organisation' => 'organisation',
                'hcp' => 'hcp',
                'category' => 'category',
                'pf_number' => 'pf_number',
                'first_name' => 'first_name',
                'middle_name' => 'middle_name',
                'last_name' => 'last_name',
                'gender' => 'gender',
                'date_of_birth' => 'date_of_birth',
                'email' => 'email',
                'phone_number' => 'phone_number',
                'address' => 'address',
                'nin' => 'nin',
                'marital_status' => 'marital_status',
                'picture' => 'picture',
                'blood_group' => 'blood_group',
                'illness' => 'illness',
                'date_of_first_appointment' => 'date_of_first_appointment',
                'occupation' => 'occupation',
                'designation' => 'designation',
                'station' => 'station',
                'hmo' => 'hmo' 
            ]
        ]);
    }
}
