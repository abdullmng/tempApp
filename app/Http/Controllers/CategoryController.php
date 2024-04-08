<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getByBranch($branch_id)
    {
        $category = Category::where("branch_id", $branch_id)->get();
        return response()->json($category);
    }
}
