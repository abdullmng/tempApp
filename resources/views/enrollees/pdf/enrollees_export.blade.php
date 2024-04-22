<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Enrollees</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #f1f1f1;
        }
        th, td {
            padding: 5px;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">FCT HEALTH INSURANCE SCHEME (FHIS)</h1>
    <h1 style="text-align: center">Enrollees</h1>
    <h4 style="text-align: center">{{ $date_range[0].' - '. $date_range[1] }}</h4>
    <div>
        <table>
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Picture</th>
                    <th>Reference</th>
                    <th>Branch</th>
                    <th>Sector</th>
                    <th>Category</th>
                    <th>Organisation</th>
                    <th>HCP</th>
                    <th>PF Number</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Date of Birth</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>NIN</th>
                    <th>Marital Status</th>
                    <th>Blood Group</th>
                    <th>Illness</th>
                    <th>Date of First Appointment</th>
                    <th>Occupation</th>
                    <th>Designation</th>
                    <th>Station</th>
                    <th>HMO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($enrollees as $enrollee)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><img src="{{ $enrollee->picture }}" class="img-fluid" style="width: 50px; height: 50px"  alt=""></td>
                        <td>{{ $enrollee->reference }}</td>
                        <td>{{ $enrollee->branch_name }}</td>
                        <td>{{ $enrollee->sector_name }}</td>
                        <td>{{ $enrollee->category_name }}</td>
                        <td>{{ $enrollee->organisation_name }}</td>
                        <td>{{ $enrollee->hcp_name }}</td>
                        <td>{{ $enrollee->pf_number }}</td>
                        <td>{{ $enrollee->first_name }}</td>
                        <td>{{ $enrollee->middle_name }}</td>
                        <td>{{ $enrollee->last_name }}</td>
                        <td>{{ $enrollee->gender }}</td>
                        <td>{{ $enrollee->date_of_birth }}</td>
                        <td>{{ $enrollee->email }}</td>
                        <td>{{ $enrollee->phone_number }}</td>
                        <td>{{ $enrollee->address }}</td>
                        <td>{{ $enrollee->nin }}</td>
                        <td>{{ $enrollee->marital_status }}</td>
                        <td>{{ $enrollee->blood_group_name }}</td>
                        <td>{{ $enrollee->illness }}</td>
                        <td>{{ $enrollee->date_of_first_appointment }}</td>
                        <td>{{ $enrollee->occupation }}</td>
                        <td>{{ $enrollee->designation }}</td>
                        <td>{{ $enrollee->station }}</td>
                        <td>{{ $enrollee->hmo }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>