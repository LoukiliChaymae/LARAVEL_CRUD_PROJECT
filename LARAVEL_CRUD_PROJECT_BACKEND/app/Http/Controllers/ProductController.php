<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsValidationRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    const HTTP_CREATED = 201;
    const HTTP_NOT_FOUND = 404;
    const HTTP_NO_CONTENT = 204;
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    public function index(){
        $products = Product::all();
        return response()->json($products);
    }
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], self::HTTP_NOT_FOUND);
        }

        return response()->json($product);
    }
    public function store(ProductsValidationRequest $request){
        try {
            $data = $request->validated();
            $newProduct = Product::create($data);

            return response()->json($newProduct, self::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Database error: ' . $e->getMessage(),
            ], self::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function update(ProductsValidationRequest $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], self::HTTP_NOT_FOUND);
        }

        $data = $request->validated();
        $product->update($data);

        return response()->json($product);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], self::HTTP_NOT_FOUND);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted'], self::HTTP_NO_CONTENT);
    }
};
