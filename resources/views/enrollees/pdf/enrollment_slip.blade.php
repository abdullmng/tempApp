<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Enrollment Slip</title>
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
        td {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="head">
        <h1 style="text-align: center; margin: 2px;">FCT HEALTH INSURANCE SCHEME (FHIS)</h1>
        <h2 style="text-align: center; margin: 2px;">ENROLLMENT SLIP</h2>
        <h4 style="text-align: center;">VALID FOR THREE (3) MONTHS</h4>
    </div>
    <div style="border-bottom: 1px solid #f1f1f1">
        <p style="text-align: right;">GENERATED: {{ date('Y-m-d') }}</p>
    </div>
    <div>
        <h4>ENROLLEE PERSONAL DETAILS</h4>
        <table>
            <tr>
                <th>NAME</th>
                <th>FHSS REFERENCE</th>
                <th rowspan="2" style="padding: 0px;">
                    <img src="{{ $enrollee->picture }}" alt="picture" width="120" height="120">
                </th>
            </tr>
            <tr>
                <td>{{ strtoupper($enrollee->full_name) }}</td>
                <td>{{ strtoupper($enrollee->reference) }}</td>
            </tr>
        </table>
        <table>
            <tr>
                <th rowspan="2" style="padding: 2px">
                    <div style="width: 80%; margin: auto">
                        {!! $qr !!}
                    </div>
                </th>
                <th>PF NUMBER</th>
                <th>EMAIL</th>
            </tr>
            <tr>
                <td>{{ strtoupper($enrollee->pf_number) }}</td>
                <td>{{ strtoupper($enrollee->email) }}</td>
            </tr>
        </table>
        <table>
            <tr>
                <th>DATE OF BIRTH</th>
                <th>GENDER</th>
                <th>MARITAL STATUS</th>
            </tr>
            <tr>
                <td>{{ $enrollee->date_of_birth }}</td>
                <td>{{ strtoupper($enrollee->gender) }}</td>
                <td>{{ strtoupper($enrollee->marital_status) }}</td>
            </tr>
            <tr>
                <th>PHONE NUMBER</th>
                <th>ADDRESS</th>
                <th>NIN</th>
            </tr>
            <tr>
                <td>{{ strtoupper($enrollee->phone_number) }}</td>
                <td>{{ strtoupper($enrollee->address) }}</td>
                <td>{{ $enrollee->nin }}</td>
            </tr>
        </table>
    </div>
    <div>
        <h4>ENROLLEE EMPLOYMENT</h4>
        <table>
            <tr>
                <th>ORGANISATION</th>
                <th>HMO</th>
                <th>DATE OF FIRST APPOINTMENT</th>
            </tr>
            <tr>
                <td>{{ strtoupper($enrollee->organisation?->name) }}</td>
                <td>{{ strtoupper($enrollee->hmo) }}</td>
                <td>{{ $enrollee->date_of_first_appointment }}</td>
            </tr>
            <tr>
                <th>DESIGNATION</th>
                <th>STATION</th>
                <th>OCCUPATION</th>
            </tr>
            <tr>
                <td>{{ strtoupper($enrollee->designation) }}</td>
                <td>{{ strtoupper($enrollee->station) }}</td>
                <td>{{ strtoupper($enrollee->occupation) }}</td>
            </tr>
        </table>
    </div>
    <div>
        <h4>ENROLLEE HCP INFORMATION</h4>
        <table>
            <tr>
                <th>PRIMARY HCP</th>
                <th>BLOOD GROUP</th>
                <th>ILLNESS</th>
            </tr>
            <tr>
                <td>{{ strtoupper($enrollee->hcp?->name) }}</td>
                <td>{{ strtoupper($enrollee->blood_group?->name) }}</td>
                <td>{{ strtoupper($enrollee->illness) }}</td>
            </tr>
        </table>
    </div>
    <div>
        <h4>ENROLLEE DEPENDENTS</h4>
        <table style="margin-bottom: 25px;">
            <tbody>
                <tr>
                    <td>#</td>
                    <td>PASSPORT</td>
                    <td>FIRST NAME</td>
                    <td>LAST NAME</td>
                    <td>GENDER</td>
                    <td>DEPENDENT TYPE</td>
                    <td>DATE OF BIRTH</td>
                    <td>BLOOD GROUP</td>
                    <td>ILLNESS</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="margin-top: 30px">
        <table>
            <tr>
                <th>
                    PREPARED BY
                </th>
                <th>
                    AUTHORISED BY
                </th>
            </tr>
            <tr>
                <td>{{ strtoupper($enrollee->enrolled_by_username) }}</td>
                <td></td>
            </tr>
        </table>
    </div>
</body>
</html>