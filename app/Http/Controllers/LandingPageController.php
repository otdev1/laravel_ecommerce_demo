<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$products = Product::inRandomOrder()->take(8)->get(); //get 8 products in random order

        $products = Product::where('featured', true)->take(8)->inRandomOrder()->get();

        return view('landing-page')->with('products', $products); //allows $products variable to accessed in this view
    }

}
