<?php

namespace App\Http\Controllers;


use App\Models\Product; 
use App\Models\Category;
//Product and Category are Eloquent Models see https://laravel.com/docs/8.x/eloquent
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::inRandomOrder()->take(10)->get(); //get 8 products in random order

        $categories = Category::all();

        //return view('shop')->with('products', $products); //allows $products variable to be accessed in the shop view
        return view('shop')->with([
            'products' => $products,
            'categories' => $categories,
        ]); //allows $products and $categories variables to be accessed in the shop view
    }

    /**
     * Display a specific product.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        //$mightAlsoLike = Product::where('slug', '!=', $slug)->inRandomOrder()->take(4)->get();

        $mightAlsoLike = Product::where('slug', '!=', $slug)->mightAlsoLike()->get();
        //mightAlsoLike is a local scope of the product model see product.php

        //return view('product')->with('product', $product);
        return view('product')->with([
            'product' => $product,
            'mightAlsoLike' => $mightAlsoLike,
        ]);

    }

}
