<?php

namespace App\Http\Controllers;

use App\DataTables\SectorsDataTable;
use App\Models\Sector;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    public function index(SectorsDataTable $dataTable)
    {
        return $dataTable->render("sectors.index");
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        $data = $request->except('_token');
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();
        Sector::create($data);
        return back()->with('success','Sector created');
    }

    public function show($id)
    {
        $sector = Sector::find($id);
        return view('sectors.edit', compact('sector'));
    }

    public function update($id, Request $request)
    {
        $request->validate(['name'=> 'required']);
        $data = $request->except('_token');
        $data['updated_by'] = auth()->id();
        Sector::where('id',$id)->update($data);
        return back()->with('success', 'Sector updated');
    }

    public function delete($id)
    {
        Sector::where('id',$id)->delete();
        return back()->with('success','Sector deleted');
    }
}
