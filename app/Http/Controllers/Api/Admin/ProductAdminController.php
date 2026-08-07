<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductAdminController extends Controller
{
    public function index()
    {
        return response()->json(Product::with('category')->get());
    }

    public function store(Request $request)
    {
        $product = Product::create($request->all());
        Cache::forget('coopesq_products');
        return response()->json($product, 201);
    }

    public function show($id)
    {
        return response()->json(Product::with('category')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        Cache::forget('coopesq_products');
        return response()->json($product);
    }

    public function destroy($id)
    {
        Product::destroy($id);
        Cache::forget('coopesq_products');
        return response()->json(['message' => 'Deleted']);
    }
}
