<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.sub_categories.index', [
            'sub_categories' => SubCategory::latest()->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.sub_categories.create', [
            'categories' => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'description' => 'required',
            'category_id' => 'required',
        ];

        $validatedData = $request->validate($rules);

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('sub-categories-images');
        }

        SubCategory::create($validatedData);

        return redirect('/features/sub-categories')->with('success', 'Sub Category has been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $subCategory)
    {
        return view('pages.sub_categories.edit', [
            'sub_category' => $subCategory,
            'categories' => Category::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        $rules = [
            'name' => 'required|max:255',
            'description' => 'required',
            'category_id' => 'required',
        ];

        $validatedData = $request->validate($rules);

        if ($request->hasFile('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('sub-categories-images');
        }

        SubCategory::where('id', $subCategory->id)->update($validatedData);

        return redirect('/features/sub-categories')->with('success', 'Sub Category has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subCategory)
    {
        if ($subCategory->image) {
            Storage::delete($subCategory->image);
        }
        SubCategory::destroy($subCategory->id);

        return redirect('/features/sub-categories')->with('success', 'Sub Category has been deleted!');
    }
}
