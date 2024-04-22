<?php

namespace App\Http\Controllers;

use App\DataTables\OrganisationsDataTable;
use App\Models\Organisation;
use Illuminate\Http\Request;

class OrganisationController extends Controller
{
    public function index(OrganisationsDataTable $dataTable) 
    {
        return $dataTable->render('organisations.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $data = $request->except('_token');
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        Organisation::create($data);
        return back()->with('success','Organisation added!');
    }

    public function show($id)
    {
        $organisation = Organisation::find($id);
        return view('organisations.edit', ['organisation' => $organisation]);
    }

    public function update($id, Request $request)
    {
        $request->validate(['name' => 'required']);
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
