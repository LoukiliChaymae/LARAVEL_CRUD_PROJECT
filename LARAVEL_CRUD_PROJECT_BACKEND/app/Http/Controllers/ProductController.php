<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    const HTTP_CREATED = 201;
    public function index(){
        $products = Product::all();
        return response()->json($products);
    }
    public function store(Request $request){
        $data=$request->validate([
            'name' => 'required',
            'qty' => 'required|numeric',
            'price' => 'required|decimal:2',
           
        ]);
        //dd($data);
        $newProduct = Product::create($data);
        return response()->json($newProduct, self::HTTP_CREATED);
    }
};
