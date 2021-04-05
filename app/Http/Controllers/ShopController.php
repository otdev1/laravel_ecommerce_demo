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
        $pagination = 9;

        $categories = Category::all();


        /*check if there is a query string i.e category=category_name in the URL of the request
          and filters products based on the category*/
        if(request()->category) 
        {
            /*$products = Product::with('categories')
                                 ->whereHas('categories', function ($query) {
                                             $query->where('slug', request()->category); 
                                 })->get();*/
            /*returns a query result as a stdClass object 
             see https://laravel.com/docs/8.x/queries#running-database-queries
             see https://www.geeksforgeeks.org/what-is-stdclass-in-php/#:~:text=The%20stdClass%20is%20the%20empty,object%2C%20it%20is%20not%20modified.
             if the ->get() function is appended to whereHas('categories',...) a collection (array) of stdClass
             objects is returned*/ 
             
            $products = Product::with('categories')
                                 ->whereHas('categories', function ($query) {
                                             $query->where('slug', request()->category); 
                                 });
            /*returns a query result as a stdClass object 
             see https://laravel.com/docs/8.x/queries#running-database-queries
             see https://www.geeksforgeeks.org/what-is-stdclass-in-php/#:~:text=The%20stdClass%20is%20the%20empty,object%2C%20it%20is%20not%20modified.
             if the ->get() function is appended to whereHas('categories',...) a collection (array) of stdClass
             objects is returned*/ 
            
            //$categories = Category::all();

            //$categoryName = $categories->where('slug', request()->category)->first()->name;
                            /*get the name of the first category from the collection of categories */

            $categoryName = optional($categories->where('slug', request()->category)->first())->name;
            /*get the name of the first category from the collection of categories 
             optional value will evaulute to null if category slug does exist and invoke the the empty condition in shop.blade.pp*/

        }
        else
        {
            //$products = Product::inRandomOrder()->take(10)->get(); 
              /*get 10 products (colection of stdClass objects) in random order
              get() is used to return a collection without it a query is returned see
              https://stackoverflow.com/questions/48148472/laravel-method-paginate-does-not-exist*/

            //$products = Product::inRandomOrder()->take(12)->paginate(9); 

            // $products = Product::inRandomOrder()->take(12); 
            $products = Product::take(12); 
            /*returns a query result as a stdClass object 
             see https://laravel.com/docs/8.x/queries#running-database-queries
             see https://www.geeksforgeeks.org/what-is-stdclass-in-php/#:~:text=The%20stdClass%20is%20the%20empty,object%2C%20it%20is%20not%20modified.*/

            // $categories = Category::all();

            $categoryName = 'Featured';
        }
        
        // $products = Product::inRandomOrder()->take(10)->get(); //get 8 products in random order

        // $categories = Category::all();

        if (request()->sort == 'low_high') {
            $products = $products->orderBy('price')->paginate($pagination); 
            //orderBy must be used since $products is a representation of a query result as a stdClass object
            //$products = $products->sortBy('price'); //sortBy fucntion sorts in ascending order(for a collection) i.e low to high
        } elseif (request()->sort == 'high_low') {
            $products = $products->orderBy('price', 'desc')->paginate($pagination);
            //orderBy must be used since $products is a representation of a query result as a stdClass object
            //$products = $products->sortByDesc('price');

            /*the orderBy() method is much more efficient than the sortBy() method 
              (particularly when querying databases of a non-trivial size / at least 1k+ rows).
              This is because the orderBy() method is essentially planning out an SQL query 
              that has not yet run whereas the sortBy() method will sort the result of a query. 
              see https://www.256kilobytes.com/content/show/1923/laravel-what-is-the-difference-between-sortby-and-orderby*/
        } 
        else {
            $products = $products->paginate($pagination);
        }

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
