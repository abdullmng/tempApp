<?php

namespace App\Http\Controllers;

use App\DataTables\EnrolleesDataTable;
use App\Models\BloodGroup;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Enrollee;
use App\Models\Organisation;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
        $first_name_char = substr($request->first_name,0,1);
        $last_name_char = substr($request->last_name, 0, 1);
        $ref = $first_name_char. $last_name_char. date('ymdhis');
        $data = $request->except('_token');
        $data['reference'] = $ref;
        $data['enrolled_by'] = auth()->id();
        if (is_null($data['email'])) {
            $data['email'] = $ref.'@fhis.com';
        }

        $enrollee = Enrollee::create($data);
        return redirect(route('user.enrollee', ['id' => $enrollee->id]))->with('success','Enrollee created successfully');
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
}
