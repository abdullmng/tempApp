<?php

namespace App\Http\Controllers;

use App\DataTables\EnrolleesDataTable;
use App\Exports\EnrolleeTemplate;
use App\Imports\EnrolleesImport;
use App\Models\BloodGroup;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Enrollee;
use App\Models\Organisation;
use App\Models\Sector;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Milon\Barcode\Facades\DNS2DFacade;

class EnrolleeController extends Controller
{
    public function index(EnrolleesDataTable $dataTable)
    {
        $branches = Branch::all();
        $categories = Category::all();
        $organisations = Organisation::all();
        $sectors = Sector::all();
        return $dataTable->render('enrollees.index', ['branches' => $branches, 'organisations' => $organisations, 'sectors' => $sectors, 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'required',
            'sector_id' => 'required',
            'organisation_id' => 'required',
            'first_name' => 'required',
            'last_name'=> 'required',
            'phone_number' => 'required',
            'date_of_birth' => 'required',
        ]);
        
        $ref = $this->generateReference($request);
        $data = $request->except('_token');
        $data['reference'] = $ref;
        $data['enrolled_by'] = auth()->id();
        if (is_null($data['email'])) {
            $data['email'] = $ref.'@fhis.com';
        }

        $enrollee = Enrollee::create($data);
        return redirect(route('user.enrollee', ['id' => $enrollee->id]))->with('success','Enrollee created successfully');
    }

    protected function generateReference($request)
    {
        $reference = $this->generateReferenceWithDob($request);
        if (Enrollee::where('reference', $reference)->exists())
        {
            $reference = $this->generateReferenceWithTime($request);

            if (Enrollee::where('reference', $reference)->exists())
            {
                $reference = $this->generateReference($request);
            }
        }
        return $reference;
    }

    protected function generateReferenceWithTime($request)
    {
        $first_name_char = substr($request->first_name,0,1);
        $last_name_char = substr($request->last_name, 0, 1);
        $timestamp = date('ymdhis');
        $reference = strtoupper($first_name_char.$last_name_char). $timestamp;
        return $reference;
    }

    protected function generateReferenceWithDob($request)
    {
        $year = Carbon::now()->year;
        $dob = Carbon::parse($request->date_of_birth);
        $yob = $dob->format('Y');
        $age = $year - intval($yob);
        $first_name_char = substr($request->first_name,0,1);
        $last_name_char = substr($request->last_name, 0, 1);
        $dob_append = str_replace('-','', $request->date_of_birth);
        $arr = [0,1];
        $reference = strtoupper($first_name_char.$last_name_char). substr($age,$arr[array_rand($arr, 1)], 1). $dob_append . substr($age,$arr[array_rand($arr, 1)], 1);
        return $reference;
    }

    public function show($id)
    {
        $enrollee = Enrollee::find($id);
        $branches = Branch::all();
        $categories = Category::all();
        $organisations = Organisation::all();
        $blood_groups = BloodGroup::orderBy('name', 'asc')->get();
        $sectors = Sector::all();
        return view('enrollees.edit', ['enrollee' => $enrollee, 'branches' => $branches, 'organisations' => $organisations, 'sectors' => $sectors, 'categories' => $categories, "blood_groups" => $blood_groups]);
    }

    public function update($id, Request $request)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'marital_status' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'branch_id' => 'required',
            'organisation_id' => 'required',
            'hcp_id' => 'required',
            'blood_group_id' => 'required'
        ];
        $request->validate($rules);
        $enrollee = Enrollee::where('id', $id)->first();
        $data = $request->except('_token');
        if ($request->has('picture'))
        {
            if ($request->file('picture')->getSize() > 1500000)
            {
                return back()->withErrors(['picture' => 'file cannot be larger than 1.4mb']);
            }
            $picture = str_replace('/storage/uploads/','', $enrollee->picture);
            $path = storage_path('app/public/uploads/'. $picture);
            if (File::exists($path))
            {
                File::delete($path);
            }
            $data = $request->except('_token', 'picture');
            $file = $request->file('picture')->store('public/uploads');
            $picture = Storage::url($file);
            $data['picture'] = $picture;
        }

        if ($request->has('picture_bin'))
        {
            $data = $request->except('_token', 'picture_bin');
            $picture = $request->picture_bin;
            $data['picture'] = $picture;
        }
        $data['updated_by'] = auth()->id();
        $enrollee->update($data);
        return back()->with('success','Enrollee data updated successfully');
    }

    public function downloadTemplate()
    {
        return Excel::download(new EnrolleeTemplate, 'enrolleeImportTemplate.xlsx');
    }

    public function storeImport(Request $request)
    {
        $request->validate([
            'file' => 'required'
        ]);

        $file = $request->file('file');
        Excel::import(new EnrolleesImport, $file);
        return back()->with('success', 'Import completed');
    }

    public function printSlip($id)
    {
        $enrollee = Enrollee::find($id);
        $qrcode = DNS2DFacade::getBarcodeHTML('https://'.request()->getHost().'/enrollees/slip/verify/'.$enrollee->reference.'', 'QRCode', 3, 3, 'navy');
        return Pdf::loadView('enrollees.pdf.enrollment_slip', ['enrollee' => $enrollee, 'qr' => $qrcode])->stream('slip.pdf');
    }

    public function printIdCard($id)
    {
        $enrollee = Enrollee::find($id);
        //$qrcode = DNS2DFacade::getBarcodeHTML('https://'.request()->getHost().'/enrollees/slip/verify/'.$enrollee->reference.'', 'QRCode', 3, 3, 'navy');
        if (is_null($enrollee->picture))
        {
            return back()->withErrors(['picture' => 'Cannot generate ID Card, please capture an image.']);
        }

        $pdf = Pdf::loadView('enrollees.pdf.idcard', ['enrollee' => $enrollee/*, 'qr' => $qrcode*/]);
        $pdf->getDomPDF()->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer' => false,
                    'verify_peer_name' => false
                ]
            ])
        );
        return $pdf->stream('idcard.pdf');
    }

    public function verify($id)
    {
        $enrollee = Enrollee::where('reference',$id)->first();
        $qrcode = DNS2DFacade::getBarcodeHTML('https://'.request()->getHost().'/enrollees/slip/verify/'.$enrollee->id.'', 'QRCode', 2.5, 2.5);
        return view('enrollees.pdf.slip', ['enrollee' => $enrollee, 'qr' => $qrcode]);
    }

    public function enrollmentData(Request $request)
{
    $startDate = Carbon::now()->subDays(7)->startOfDay();
    $endDate = Carbon::now()->endOfDay();

    //dd($startDate, $endDate);
    $enrollees = Enrollee::whereBetween('created_at', [$startDate, $endDate])
                            ->orderBy('created_at')
                            ->get();
    $days = [];
    $dates = $enrollees->pluck('created_at')->map(function ($date){
        return $date->format('Y-m-d');
    })->unique()->values()->toArray();

    foreach($dates as $date)
    {
        $days[] = Carbon::parse($date)->format('D');
    }
    
    $enrollmentCounts = [];
    foreach ($dates as $date) {
        $enrollmentCounts[] = Enrollee::where('created_at', 'like', '%'. $date . '%')->count();
    }

    return response()->json([
        'dates' => $days,
        'enrollmentCounts' => $enrollmentCounts,
    ]);
}
}
