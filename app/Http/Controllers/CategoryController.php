<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.categories.index', [
            'categories' => Category::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->image === null) {
            $rules = [
                'name' => 'required|max:255',
                'description' => 'required',
            ];
        } else {
            $rules = [
                'name' => 'required|max:255',
                'description' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ];
        }

        $validatedData = $request->validate($rules);

        if ($request->image) {
            $validatedData['image'] = $request->file('image')->store('category-images');
        }

        Category::create($validatedData);

        return redirect('/features/categories')->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('pages.categories.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        if ($request->image === null) {
            $rules = [
                'name' => 'required|max:255',
                'description' => 'required',
            ];
        } else {
            $rules = [
                'name' => 'required|max:255',
                'description' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            ];
        }

        $validatedData = $request->validate($rules);

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('product-images');
        }

        Category::where('id', $category->id)->update($validatedData);

        return redirect('/features/categories')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->products->count()) {
            return redirect('/features/categories')->with('error', 'Some Products Using This Category');
        }

        Category::destroy($category->id);

        return redirect('/features/categories')->with('success', 'Category deleted successfully!');
    }
}
