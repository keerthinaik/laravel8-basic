<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    function allCategory()
    {
        $categories = Category::latest()->paginate(4);

        // code of query builder join table to join with user table to retrieve user's name
//        $categories = DB::table('categories')
//            ->join('users', 'categories.user_id', 'users.id')
//            ->select('categories.*', 'users.name as user_name')->latest()->paginate(4);

        return view('admin.category.index', compact('categories'));
    }

    function editCategory($id) {
//        $category = Category::find($id);

        // Query builder syntax
        $category = DB::table('categories')->where('id', $id)->first();
        return view('admin.category.edit', compact('category'));
    }

    function updateCategory(Request $request, $id) {
        $validateData = $request->validate([
            'name' => 'required|unique:categories|max:20',

        ], [
            'name.required' => 'category name should not be empty',
        ]);
//        $update = Category::find($id)->update([
//           'name' => $request->name,
//            'user_id' => Auth::user()->id,
//        ]);

        // Query builder syntax for updating data
        $data = array();
        $data['name']=$request->name;
        $data['user_id'] = Auth::user()->id;
        DB::table('categories')->where('id', $id)->update($data);
        return Redirect::route('all.category')->with('success', 'Category Updated Successfully');
    }

    function addCategory(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:categories|max:20',

        ], [
            'name.required' => 'category name should not be empty',
        ]);

//        Category::insert([
//           'name' => $request->name,
//            'user_id' => Auth::user()->id,
//            'created_at' => Carbon::now()
//        ]);

//        $category = new Category();
//        $category->name = $request->name;
//        $category->user_id = Auth::user()->id;
//        $category->save();

        $data = array();
        $data['name'] = $request->name;
        $data['user_id'] = Auth::user()->id;
        DB::table('categories')->insert($data);

        return Redirect::back()->with('success', 'Category Inserted Successfully');
    }
}
