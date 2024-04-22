<?php

namespace App\Http\Controllers;

use App\DataTables\CategoriesDataTable;
use App\Models\Branch;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getByBranch($branch_id)
    {
        $category = Category::where("branch_id", $branch_id)->get();
        return response()->json($category);
    }

    public function index(CategoriesDataTable $dataTable)
    {
        $branches = Branch::all();
        return $dataTable->render('categories.index', ['branches' => $branches]);
    }

    public function store(Request $request)
    {
        $this->validate($request, ['branch_id' => 'required', 'name' => 'required'], ['branch_id' => 'The branch field is required']);
        $data = $request->except('_token');
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();
        Category::create($data);
        return back()->with('success', 'Category created!');
    }

    public function show($id)
    {
        $category = Category::find($id);
        $branches = Branch::all();
        return view('categories.edit', ['category'=> $category, 'branches' => $branches]);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, ['branch_id' => 'required', 'name' => 'required'], ['branch_id' => 'The branch field is required']);
        $data = $request->except('_token');
        $data['updated_by'] = auth()->id();
        Category::where('id', $id)->update($data);
        return back()->with('success', 'Category updated!');
    }

    public  function delete($id)
    {
        Category::destroy($id);
        return back()->with('success','Category deleted');
    }
}
