<html>

<head>
    <style type="text/css">
        @page {
            size: auto;
            margin: 0mm;
        }

        @media all {
            body {
                margin: 0px;
                font-size: 9px;
            }

            table {
                font-size: 7px;
            }

            .card_front {
                background: url('{{ asset("front-pattern.png") }}') no-repeat;
                /*height: 5.30cm;
                width: 8.63cm;*/
                height: 5.583cm;
                width: 8.63cm;
                border: 1px solid green;
                border-radius: 10px;
            }

            .red {
                color: red;
            }

            .pg_break {
                page-break-after: always;
            }

            .card_back {
                /*background: url('back.jpg') no-repeat;*/
                height: 5.583cm;
                width: 8.63cm;
                /*height: 5.54cm;
                width: 8.63cm;*/
                margin-top: 0.2cm;
                border: 1px solid green;
                border-radius: 10px;
                /*border:1px solid red;*/
                /*padding-left:0.2cm;
                padding-top: 0.3cm;
                padding-right:0.2cm;*/
            }

            .card_back tr.bordered_tr td {
                border: 1px dotted;
            }

            .contain {
                width: 50%;
                margin-left: auto;
                margin-right: auto;
                margin-top: 250px;
            }

            .qr-code {
                width: 60%;
                margin: auto;
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="contain">
        <!--Enrollee -->
        <div class="card_front" style="/*border:1px solid red;*/">
            {{--<div style="float:left; width:4.8cm; margin-top:1.7cm; padding-left:0.23cm;">
                <h3 style="color:green; margin-bottom: 4px">FCT HEALTH INSURANCE SCHEME</h3>
                <h4 style="margin-bottom: 4px;">Federal Capital Territory Administration</h4>
            </div>
            <div style="float:left; width:1.6cm; padding-left:0.62cm; padding-top:0.48cm;">
                <img src="{{ $enrollee->picture }}"
                    style="width:50px; height:50px; border-radius: 10px;" />
            </div>--}}
            <table width="100%" style="margin-top: 10px; margin-bottom: 0.42cm">
                <tr>
                    <th width="25%"></th>
                    <th width="65%">
                        <h2 style="color:rgb(7, 67, 7); margin-bottom: 4px"><strong>FCT HEALTH INSURANCE SCHEME</strong></h2>
                        <h3 style="margin-bottom: 4px;"><strong>Federal Capital Territory Administration</strong></h3>
                    </th>
                    <th width="10%">
                        <img src="{{ $enrollee->picture }}" style="width:65px; height:65px; border-radius: 10px;border:2px solid green; margin-right: 5px;" />
                    </th>
                </tr>
            </table>
            <!--<div style="margin-left:5.8cm; padding-top:0.36cm;">
            <img src="https://fhis.abj.gov.ng/app/public/uploads/bhcpf/14187086931713445168.jpg" style="width:100px; height:100px; border-radius: 10px;"/>
        </div>-->
            <div style="clear:both">
                <div style="float:left;width:20%; text-align: center">
                    <span class="red" style="font-weight: bold;">Sex</span>
                    <span> {{ $enrollee->gender }} </span>
                </div>
                <div style="float:left; width:25%; text-align: center">
                    <span class="red" style="font-weight: bold;">Blood Group</span>
                    <span> {{ $enrollee->blood_group?->name }} </span>
                </div>
                <div style="float:left; width:55%; text-align: center">
                    <span style="font-weight: bold">{{ $enrollee->full_name }}</span>
                </div>
            </div>
            <div style="clear:both;margin-top: 20px; margin-bottom: 0.75cm">
                <div class="red" style="text-align: center; font-weight: bold;">FHIS No.</div>
                <div style="font-weight: bold; text-align: center; padding-top: 5px; font-size:12px;">{{ $enrollee->reference }}</div>
            </div>
            <div style="margin-top: 5px;">
                <div style="float:left; width:40%; text-align: center" class="red">Date of Birth</div>
                <div style="float:left; width:20%; text-align: center" class="red"></div>
                <div style="float:left; width:40%; text-align: center" class="red">Date Issued</div>
            </div>
            <div style="clear:both;">
                <div style="float:left; width:40%; text-align: center;">{{ $enrollee->date_of_birth }}</div>
                <div style="float:left; width:20%; text-align: center;"></div>
                <div style="float:left; width:40%; text-align: center;">{{ date('Y-m-d') }}</div>
            </div>
        </div>
        <div class="card_back">
            <div style="padding:10px;"><span class="red"></span></div>
            <div style=""><span class="red">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span>
            </div>
            <div style="padding:5px;">

            </div>
            <div>
                <div style="float:left; width:60%; padding: 5px 10px;">
                    <p class="red">This card is the property of FCT Health Services Scheme (FHIS). If found please return
                        to the
                        Health & Human Services Secretariat, FCT Area 11 Abuja.</p>
                </div>
                <div style="float:left; width:30%; text-align: center;">
                    <img src="{{ asset('sign.jpg') }}" style="width:100px;" />
                </div>
                <div style="clear:both;"></div>
            </div>
            <div class="qr-code" style="margin-bottom: 2px; text-align:center">
                <img src="data:image/jpeg;base64,{!! $qr !!}" alt="" srcset="">
            </div>
        </div>
        <!--end Enrollee -->
    </div>
</body>

</html>
