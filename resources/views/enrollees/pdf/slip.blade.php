<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Enrollee Slip</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border: none;
            margin-bottom: 10px;
        }
        thead, tbody, th, td, tr {
            border: none;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th colspan="3">
                    <h1 style="text-align: center; margin: 2px;">FCT HEALTH INSURANCE SCHEME (FHIS)</h1>
                    <h2 style="text-align: center; margin: 2px;">ENROLLMENT SLIP</h2>
                    <h4 style="text-align: center;">Valid for Three (3) Months</h4>
                </th>
            </tr>
            <tr>
                <th style="border-bottom: 1px solid #f4f4f4" colspan="3">
                    <p style="text-align: right; margin-bottom: 0px">Generated On: {{ date('Y-m-d') }}</p>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="border-bottom: 1px solid #f4f4f4" colspan="3">
                    <h4 style="margin-bottom: 0px;">ENROLLEE PERSONAL DETAILS</h4>
                </td>
            </tr>
            <tr>
                <td width="40%" style="border-bottom: 1px solid #f4f4f4;" >
                    <strong>NAME:</strong> {{ $enrollee->full_name }}
                </td>
                <td width="50%" style="border-bottom: 1px solid #f4f4f4; padding: 10px;" >
                    <strong>FHSS REFERENCE:</strong>
                    {{ $enrollee->reference }}
                </td>
                <td width="10%" style="border-bottom: 1px solid #f4f4f4; padding: 10px;" >
                    <img src="{{ $enrollee->picture }}" alt="picture" style="width: 100%;">
                </td>
            </tr>
            <tr>
                <td width="40%" style="border-bottom: 1px solid #f1f1f1">
                    <strong>PF NUMBER:</strong> {{ $enrollee->pf_number }}
                </td>
                <td width="50%" style="border-bottom: 1px solid #f1f1f1">
                    <strong>EMAIL:</strong>
                    {{ $enrollee->email }}
                </td>
                <td width="10%" style="border-bottom: 1px solid #f1f1f1">
                    <div style="width: 100%; padding: 10px;">{!! $qr !!}</div>
                </td>
            </tr>
            <tr>
                <td width="40%" style="border-bottom: 1px solid #f1f1f1; padding: 10px">
                    <strong>DATE OF BIRTH:</strong> {{ $enrollee->date_of_birth }}
                </td>
                <td width="50%" style="border-bottom: 1px solid #f1f1f1; padding: 10px">
                    <strong>GENDER:</strong>
                    {{ $enrollee->gender }}
                </td>
                <td width="10%" style="border-bottom: 1px solid #f1f1f1">
                    
                </td>
            </tr>
            <tr>
                <td width="40%" style="border-bottom: 1px solid #f1f1f1; padding: 10px">
                    <strong>MARITAL STATUS:</strong> {{ $enrollee->marital_status }}
                </td>
                <td width="50%" style="border-bottom: 1px solid #f1f1f1; padding: 10px">
                    <strong>PHONE NUMBER:</strong>
                    {{ $enrollee->phone_number }}
                </td>
                <td width="10%" style="border-bottom: 1px solid #f1f1f1">
                    
                </td>
            </tr>
            <tr>
                <td width="40%" style="border-bottom: 1px solid #f1f1f1; padding: 10px">
                    <strong>ADDRESS:</strong> {{ $enrollee->address }}
                </td>
                <td width="50%" style="border-bottom: 1px solid #f1f1f1; padding: 10px">
                    <strong>NIN:</strong>
                    {{ $enrollee->nin }}
                </td>
                <td width="10%" style="border-bottom: 1px solid #f1f1f1">
                    
                </td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #f4f4f4" colspan="3">
                    <h4 style="margin-bottom: 0px;">ENROLLEE EMPLOYMENT</h4>
                </td>
            </tr>
            <tr>
                <td width="40%" style="border-bottom: 1px solid #f1f1f1; padding: 10px">
                    <strong>ORGANISATION:</strong> {{ $enrollee->organisation?->name }}
                </td>
                <td width="50%" style="border-bottom: 1px solid #f1f1f1; padding: 10px">
                    <strong>HMO:</strong>
                    {{ $enrollee->hmo }}
                </td>
                <td width="10%" style="border-bottom: 1px solid #f1f1f1">
                    
                </td>
            </tr>
            <tr>
                <td width="40%" style="border-bottom: 1px solid #f1f1f1; padding: 10px">
                    <strong>DATE OF FIRST APPOINTMENT:</strong> {{ $enrollee->date_of_first_appointment }}
                </td>
                <td width="50%" style="border-bottom: 1px solid #f1f1f1; padding: 10px">
                    <strong>DESIGNATION:</strong>
                    {{ $enrollee->designation }}
                </td>
                <td width="10%" style="border-bottom: 1px solid #f1f1f1">
                    
                </td>
            </tr>
            <tr>
                <td width="40%" style="border-bottom: 1px solid #f1f1f1; padding: 10px">
                    <strong>STATION:</strong> {{ $enrollee->station }}
                </td>
                <td width="50%" style="border-bottom: 1px solid #f1f1f1; padding: 10px">
                    <strong>OCCUPATION:</strong>
                    {{ $enrollee->occupation }}
                </td>
                <td width="10%" style="border-bottom: 1px solid #f1f1f1">
                    
                </td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #f4f4f4" colspan="3">
                    <h4 style="margin-bottom: 0px;">ENROLLEE HCP INFORMATION</h4>
                </td>
            </tr>
            <tr>
                <td width="40%" style="border-bottom: 1px solid #f1f1f1; padding: 10px">
                    <strong>PRIMARY HCP:</strong> {{ $enrollee->hcp?->name }}
                </td>
                <td width="50%" style="border-bottom: 1px solid #f1f1f1; padding: 10px">
                    <strong>BLOOD GROUP:</strong>
                    {{ $enrollee->blood_group?->name }}
                </td>
                <td width="10%" style="border-bottom: 1px solid #f1f1f1">
                    
                </td>
            </tr>
            <tr>
                <td width="40%" style="border-bottom: 1px solid #f1f1f1; padding: 10px">
                    <strong>ILLNESS:</strong> {{ $enrollee->illness }}
                </td>
                <td width="50%" style="border-bottom: 1px solid #f1f1f1; padding: 10px">
                    
                </td>
                <td width="10%" style="border-bottom: 1px solid #f1f1f1">
                    
                </td>
            </tr>
        </tbody>
    </table>
    <table style="margin-bottom: 25px;">
        <tbody>
            <tr>
                <td style="border-bottom: 1px solid #f4f4f4" colspan="9">
                    <h4 style="margin-bottom: 0px;">ENROLLEE DEPENDENTS</h4>
                </td>
            </tr>
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

    <table>
        <tr>
            <td>
                <strong>PREPARED BY:</strong>
                {{ $enrollee->enrolled_by_username }}
            </td>
            <td>
                <strong>AUTHORISED BY</strong>

            </td>
        </tr>
    </table>
</body>
</html>