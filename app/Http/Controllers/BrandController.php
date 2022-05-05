<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BrandController extends Controller
{
    function allBrand() {
        $brands = Brand::latest()->paginate(4);
        return view('admin.brand.index', compact('brands'));
    }

    function addBrand(Request $request) {
        $vaildateData = $request->validate([
            'name' => 'required|unique:brands|max:20',
            'image' => 'required|mimes:jpg,jpeg,png',
        ], [
            'name.required' => 'Please enter the name',
            'image.required' => 'Please add the brand image',
            'image.mimes' => 'Only png, jpg and jpeg are allowed',
        ]);

        $image = $request->file('image');

        $name_gen = hexdec(uniqid());
        $image_extension = $image->getClientOriginalExtension();
        $image_name = $name_gen.'.'.$image_extension;
        $upload_directory = 'images/brand/';
        $image_path = $upload_directory.$image_name;
        $image->move($upload_directory, $image_name);

        Brand::insert([
           'name' => $request->name,
            'image' => $image_path,
            'created_at' => Carbon::now(),
        ]);

        return Redirect::back()->with('success', 'Brand Inserted Successfully');
    }

    function editBrand($id) {
        $brand = Brand::find($id);
        return view('admin.brand.edit', compact('brand'));
    }

    function updateBrand(Request $request, $id) {
        $vaildateData = $request->validate([
            'name' => 'required|max:20',
            'image' => 'mimes:jpg,jpeg,png',
        ], [
            'name.required' => 'Please enter the name',
            'image.mimes' => 'Only png, jpg and jpeg are allowed',
        ]);

        $image = $request->file('image');

        // if image also need to be updated then $image will have some value
        if ($image) {
            $oldImage = $request->old_image;
            $name_gen = hexdec(uniqid());
            $image_extension = $image->getClientOriginalExtension();
            $image_name = $name_gen.'.'.$image_extension;
            $upload_directory = 'images/brand/';
            $image_path = $upload_directory.$image_name;
            $image->move($upload_directory, $image_name);

            // remove the old image
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }

            Brand::find($id)->update([
                'name' => $request->name,
                'image' => $image_path,
            ]);
            return Redirect::back()->with('success', 'Brand Updated Successfully');
        } else {
            Brand::find($id)->update([
                'name' => $request->name,
            ]);
            return Redirect::back()->with('success', 'Brand Updated Successfully');
        }
    }

    function deleteBrand($id) {
        $brand = Brand::find($id);
        if (file_exists($brand->image)) {
            unlink($brand->image);
        }
        $brand->delete();
        return Redirect::back()->with('success', 'Brand Deleted Successfully');
    }
}
