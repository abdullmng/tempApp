<?php

namespace App\Http\Controllers;

use App\DataTables\EnrolleesDataTable;
use App\Exports\EnrolleesRawExport;
use App\Exports\EnrolleeTemplate;
use App\Imports\EnrolleesImport;
use App\Imports\EnrolleesRawImport;
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
        $this->validate($request,
        [
            'branch_id' => 'required',
            'sector_id' => 'required',
            'organisation_id' => 'required',
            'first_name' => 'required',
            'last_name'=> 'required',
            'phone_number' => 'required',
            'date_of_birth' => 'required',
        ], [
            'branch_id' => 'The branch field is required',
            'sector_id' => 'The sector field is required',
            'organisation_id' => 'The organisation field is required'
        ]);
        
        $ref = $this->generateReference($request);
        $organisation = Organisation::where('id', $request->organisation_id)->first();
        $data = $request->except('_token');
        $data['reference'] = $ref;
        $data['hmo_id'] = $organisation->hmo_id;
        $data['hmo'] = $organisation->hmo_name;    
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
        $organisation = Organisation::where('id', $request->organisation_id)->first();
        $area = substr($organisation->name, 0, 2);
        $timestamp = date('ymdhis');
        $reference = strtoupper($first_name_char.$last_name_char.$area). $timestamp;
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
        $organisation = Organisation::where('id', $request->organisation_id)->first();
        $area = substr($organisation->name, 0, 2);
        $reference = strtoupper($first_name_char.$last_name_char.$area). substr($age,$arr[array_rand($arr, 1)], 1). $dob_append . substr($age,$arr[array_rand($arr, 1)], 1);
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
        $this->validate( $request, 
        $rules, [
            'branch_id' => 'The branch field is required',
            'organisation_id' => 'The organisation field is required',
            'hcp_id' => 'The HCP field is required',
            'blood_group_id' => 'The blood group field is required'
        ]);
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
        $organisation = Organisation::where('id', $request->organisation_id)->first();
        $data['hmo_id'] = $organisation->hmo_id;
        $data['hmo'] = $organisation->hmo_name;    
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
        $count = intval($enrollee->id_printout_count);
        $count += 1;
        //$qrcode = DNS2DFacade::getBarcodeHTML('https://'.request()->getHost().'/enrollees/slip/verify/'.$enrollee->reference.'', 'QRCode', 3, 3, 'green');
        $qrcode = DNS2DFacade::getBarcodePNG('https://'.request()->getHost().'/enrollees/slip/verify/'.$enrollee->reference.'', 'QRCode', 3, 3);
        if (is_null($enrollee->picture))
        {
            return back()->withErrors(['picture' => 'Cannot generate ID Card, please capture an image.']);
        }

        //dd($qrcode);

        $pdf = Pdf::loadView('enrollees.pdf.idcard', ['enrollee' => $enrollee, 'qr' => $qrcode]);
        $pdf->getDomPDF()->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer' => false,
                    'verify_peer_name' => false
                ]
            ])
        );
        $enrollee->update(['id_printout_count' => $count]);
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

    public function rawExportView()
    {
        $branches = Branch::all();
        $sectors = Sector::all();
        $organisations = Organisation::all();
        return view('enrollees.raw_export', compact('branches', 'sectors', 'organisations'));
    }

    public function rawExport(Request $request)
    {
        $request->validate([
            'branch' => 'nullable|integer',
            'sector' => 'nullable|integer',
            'category' => 'nullable|integer',
            'organisation' => 'nullable|integer',
            'hcp' => 'nullable|integer',
            'date_from' => 'required|date_format:Y-m-d',
            'date_to' => 'required|date_format:Y-m-d',
        ]);

        $branch = $request->branch;
        $sector = $request->sector;
        $category = $request->category;
        $organisation = $request->organisation;
        $hcp = $request->hcp;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $date_range = [$date_from, $date_to];

        $query = Enrollee::query();

        $columns = ['reference', 'branch_id', 'sector_id', 'category_id', 'organisation_id', 'hcp_id', 'pf_number', 'first_name', 'middle_name', 'last_name', 'gender', 'date_of_birth', 'email', 'phone_number', 'address', 'nin', 'id_printout_count', 'marital_status', 'picture', 'blood_group_id', 'illness', 'organization', 'date_of_first_appointment', 'occupation', 'designation', 'station', 'hmo_id', 'hmo', 'enrolled_by', 'updated_by', 'created_at', 'updated_at'];

        // Apply filters based on input parameters
        if (!is_null($branch)) {
            $query->where('enrollees.branch_id', $branch);
        }


        if (!is_null($sector))
        {
            $query->where('enrollees.sector_id', $sector);
        }

        if (!is_null($category))
        {
            $query->where('enrollees.category_id', $category);
        }

        if (!is_null($organisation))
        {
            $query->where('enrollees.organisation_id', $organisation);
        }

        if (!is_null($hcp))
        {
            $query->where('enrollees.hcp_id', $hcp);
        }

        if (!is_null($date_from) && !is_null($date_to))
        {
            $query->whereBetween('enrollees.created_at', $date_range);
        }

        $headingRow = $columns;

        $enrollees = $query->select($columns)->get()->toArray();
        $headingRow = [$headingRow];
        return Excel::download(new EnrolleesRawExport($enrollees, $headingRow), 'enrollees_'.$date_from.'_'.$date_to.'.xlsx');
    }

    public function rawImportView()
    {
        return view('enrollees.raw_import');
    }

    public function rawImport(Request $request)
    {
        $request->validate([
            'file' => 'required'
        ]);

        $file = $request->file('file');
        Excel::import(new EnrolleesRawImport, $file);
        return back()->with('success', 'Import completed');
    }
}
