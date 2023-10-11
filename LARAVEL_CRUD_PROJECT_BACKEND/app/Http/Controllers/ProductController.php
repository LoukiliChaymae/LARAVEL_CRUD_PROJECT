<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    public function index(){
        return view('products.index');
    }
    public function create(){
        return view('products.create');
    }
    public function store(Request $request){
        $data=$request->validate([
            'name' => 'required',
            'qty' => 'required|numeric',
            'price' => 'required|decimal:2',
           
        ]);
        //dd($data);
        $newProduct = Product::create($data);
        //$newProduct = new Product()

        //return redirect(route('product.index'));
    }
};
