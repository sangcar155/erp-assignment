<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
        */
        
    public function index()
    {
        $products = Product::latest()->paginate(10); // ✅ This enables pagination
        return view('products.index', compact('products'));
    }


    public function create()
    {
        return view('products.create');
    }

    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated());
        return redirect()->route('products.index')->with('success', 'Product added!');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(StoreProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }   


    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted!');
    }
}
