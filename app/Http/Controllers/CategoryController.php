<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    function allCategory() {
        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }

    function addCategory(Request $request) {
        $validateData = $request->validate([
            'name' => 'required|unique:categories|max:20',

        ],[
            'name.required' => 'category name should not be empty',
        ]);

//        Category::insert([
//           'name' => $request->name,
//            'user_id' => Auth::user()->id,
//            'created_at' => Carbon::now()
//        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->user_id = Auth::user()->id;
        $category->save();

        return Redirect::back()->with('success', 'Category Inserted Successfully');
    }
}
