<?php

namespace App\Http\Controllers;

use App\DataTables\HmosDataTable;
use App\Models\Hmo;
use App\Models\Organisation;
use Illuminate\Http\Request;

class HmoController extends Controller
{
    public function index(HmosDataTable $dataTable) 
    {
        return $dataTable->render("hmos.index");
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        $data = $request->except('_token');
        $char = strtoupper(substr($request->name,0,1));
        $data['code'] = uniqid($char);
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();
        $hmo = Hmo::create($data);
        return back()->with('success','HMO created');
    }

    public function show($id)
    {
        $hmo = Hmo::find($id);
        return view('hmos.edit', compact('hmo'));
    }

    public function update($id, Request $request)
    {
        $request->validate(['name'=> 'required']);
        $data = $request->except('_token');
        $data['updated_by'] = auth()->id();
        Hmo::where('id', $id)->update($data);
        return back()->with('success','Hmo updated!');
    }

    public function delete($id)
    {
        Hmo::where('id', $id)->delete();
        Organisation::where('hmo_id', $id)->delete();
        return back()->with('success','Hmo deleted');
    }
}
