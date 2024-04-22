<?php

namespace App\Http\Controllers;

use App\DataTables\BranchesDataTable;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index(BranchesDataTable $dataTable)
    {
        return $dataTable->render("branches.index");
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $branch = Branch::create($request->except('_token'));
        return back()->with('success', 'Branch created');
    }

    public function show($id)
    {
        $branch = Branch::find($id);
        return view('branches.edit', ['branch' => $branch]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $branch = Branch::where('id', $id)->first();
        $branch->update(['name' => $request->name]);
        return back()->with('success','Branch Updated');
    }

    public function delete($id)
    {
        Branch::destroy($id);
        return back()->with('success','branch deleted');
    }
}
