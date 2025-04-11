<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProductCreated;

class ProductController extends Controller
{
    public function index() {
        $products = Product::get();
        return view('products.index', compact('products'));
    }

    public function create() {
        return view('products.create');
    }
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required',
        'description' => 'required',
        'price' => 'required|numeric',
        'status' => 'required'
    ]);

    $product = new Product($validated);
    $product->user_id = auth()->id();
    $product->save();

    // send email to the creator
    Mail::to(auth()->user()->email)->send(new ProductCreated($product, auth()->user()));

    return redirect('/products')->with('success', 'Product created and email notification sent!');
}
}
