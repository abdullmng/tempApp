<?php

namespace App\Http\Controllers;

use App\DataTables\HcpsDataTable;
use App\Models\Hcp;
use App\Models\Organisation;
use Illuminate\Http\Request;

class HcpController extends Controller
{
    public function getByOrganisation($organisation_id)
    {
        $hcps = Hcp::where('organisation_id', $organisation_id)->get();
        return response()->json($hcps);
    }

    public function index(HcpsDataTable $dataTable)
    {
        $organisations = Organisation::all();
        return $dataTable->render('hcps.index', ['organisations' => $organisations]);
    }

    public function store(Request $request)
    {
        $this->validate($request, ['organisation_id' => 'required', 'name' => 'required'], ['organisation_id' => 'The organisation field is required']);
        $data = $request->except('_token');
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();
        Hcp::create($data);
        return back()->with('success','HCP created');
    }

    public function show($id) 
    {
        $hcp = Hcp::find($id);
        $organisations = Organisation::all();
        return view('hcps.edit', ['hcp'=> $hcp, 'organisations' => $organisations]);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, ['organisation_id' => 'required', 'name' => 'required'], ['organisation_id' => 'The organisation field is required']);
        $data = $request->except('_token');
        $data['updated_by'] = auth()->id();
        Hcp::where('id', $id)->update($data);
        return back()->with('success','HCP updated');
    }

    public function delete($id)
    {
        Hcp::destroy($id);
        return back()->with('success', 'HCP deleted!');
    }
}
