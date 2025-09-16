<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest();
        return view('pages.products.index', [
            'products' => $products->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.products.create', [
            'categories' => Category::all(),
            'sub_categories' => SubCategory::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->image === null) {
            $rules = [
                'name' => 'required|max:255',
                'category_id' => 'required',
                'sub_category_id' => 'required',
                'description' => 'required',
                'price' => 'required',
                'status' => 'required|in:1,0',
                'stock' => 'required',
            ];
        } else {
            $rules = [
                'name' => 'required|max:255',
                'description' => 'required',
                'category_id' => 'required',
                'sub_category_id' => 'required',
                'price' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                'status' => 'required|in:1,0',
                'stock' => 'required',
            ];
        }
        $validatedData = $request->validate($rules);

        // if ($request->category_id === null) {
        //     $validatedData['category_id'] = 1;
        // }

        if ($request->hasFile('image')) {
            $validatedData['image'] = 'storage/' . $request->file('image')->store('product-images');
        }

        Product::create($validatedData);

        return redirect('/features/products')->with('success', 'New product has been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('pages.products.edit', [
            'product' => $product,
            'categories' => Category::all(),
            'sub_categories' => SubCategory::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        if ($request->category_id === null) {
            $rules = [
                'name' => 'required|max:255',
                'price' => 'required',
                'description' => 'required',
                'status' => 'required|in:1,0',
                'stock' => 'required',
            ];
        } else {
            $rules = [
                'name' => 'required|max:255',
                'category_id' => 'required',
                'description' => 'required',
                'price' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
                'status' => 'required|in:1,0',
                'stock' => 'required',
            ];
        }
        $validatedData = $request->validate($rules);

        if ($request->category_id === null) {
            $validatedData['category_id'] = 1;
        }

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('product-images');
        }

        Product::where('id', $product->id)->update($validatedData);

        return redirect('/features/products')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::delete($product->image);
        }
        Product::destroy($product->id);

        return redirect('/features/products')->with('success', 'Product deleted successfully!');
    }
}
