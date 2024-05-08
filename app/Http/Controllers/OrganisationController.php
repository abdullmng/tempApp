<?php

namespace App\Http\Controllers;

use App\DataTables\OrganisationsDataTable;
use App\Models\Hmo;
use App\Models\Organisation;
use Illuminate\Http\Request;

class OrganisationController extends Controller
{
    public function index(OrganisationsDataTable $dataTable) 
    {
        $hmos = Hmo::all();
        return $dataTable->render('organisations.index', ['hmos' => $hmos]);
    }

    public function store(Request $request)
    {
        $this->validate($request, 
        [
            'name' => 'required', 
            'hmo_id' => 'required'
        ], 
        [
            'hmo_id' => 'The HMO field is required'
        ]);

        $data = $request->except('_token');
        $char = substr($request->name,0,3);
        $data['code'] = uniqid($char);
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        Organisation::create($data);
        return back()->with('success','Organisation added!');
    }

    public function show($id)
    {
        $organisation = Organisation::find($id);
        $hmos = Hmo::all();
        return view('organisations.edit', ['organisation' => $organisation, 'hmos' => $hmos]);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, 
        [
            'name' => 'required', 
            'hmo_id' => 'required'
        ], 
        [
            'hmo_id' => 'The HMO field is required'
        ]);
        $data = $request->except('_token');
        $data['updated_by'] = auth()->id();
        Organisation::where('id', $id)->update($data);
        return back()->with('success', 'Organisation Updated');
    }

    public function delete($id)
    {
        Organisation::where('id', $id)->delete();
        return back()->with('success','Organisation deleted');
    }
}
