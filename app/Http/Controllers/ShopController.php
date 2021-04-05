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
        /*check if there is a query string i.e category=category_name in the URL of the request
          and filters products based on the category*/
        if(request()->category) 
        {
            $products = Product::with('categories')
                                 ->whereHas('categories', function ($query) {
                                             $query->where('slug', request()->category); 
                                 })->get();
            
            $categories = Category::all();

            $categoryName = $categories->where('slug', request()->category)->first()->name;
                            /*get the name of the first category from the collection of categories */

        }
        else
        {
            $products = Product::inRandomOrder()->take(10)->get(); //get 8 products in random order

            $categories = Category::all();

            $categoryName = 'Featured';
        }
        
        // $products = Product::inRandomOrder()->take(10)->get(); //get 8 products in random order

        // $categories = Category::all();

        if (request()->sort == 'low_high') {
            // $products = $products->orderBy('price')->paginate($pagination);
            $products = $products->sortBy('price'); //sortBy fucntion sorts in ascending order i.e low to high
        } elseif (request()->sort == 'high_low') {
            //$products = $products->orderBy('price', 'desc')->paginate($pagination);
            $products = $products->sortByDesc('price');
        } 
        // else {
        //     $products = $products->paginate($pagination);
        // }

        //return view('shop')->with('products', $products); //allows $products variable to be accessed in the shop view
        return view('shop')->with([
            'products' => $products,
            'categories' => $categories,
            'categoryName' => $categoryName,
        ]); //allows $products, $categories, and $categoryName variables to be accessed in the shop view
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
