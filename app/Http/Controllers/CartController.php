<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$mightAlsoLike = Product::inRandomOrder()->take(4)->get();

        $mightAlsoLike = Product::mightAlsoLike()->get();
        //mightAlsoLike is a local scope of the product model see product.php

        return view('cart')->with('mightAlsoLike', $mightAlsoLike);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Product $product)
    {
        Cart::add($product->id, $product->name, 1, $product->price)
            ->associate('App\Models\Product');
        // Cart::add($request->id, $request->name, 1, $request->price)
        //     ->associate('App\Product');
        //add(productid, productname, productquantity, productprice, productweight)
        /*associate enables easier retrieval of the product model e.g $item->model->*field_of_product_model*
          in other sectons/files throughout the application see cart.blade.php and Product.php*/

        return redirect()->route('cart.index')->with('success_message', 'Item was added to your cart!');
    }
    /*public function store(Request $request)
    {
        Cart::add($product->id, $product->name, 1, $product->price)
            ->associate('App\Product');
        // Cart::add($request->id, $request->name, 1, $request->price)
        //     ->associate('App\Product');
        //add(productid, productname, productquantity, productprice)
        associate enables easier retrieval of the product model e.g $item->model->*field_of_product_model*
          in other sectons/files throughout the application see cart.blade.php and Product.php

        return redirect()->route('cart.index')->with('success_message', 'Item was added to your cart!');
    }*/
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::remove($id);

        return back()->with('success_message', 'Item has been removed!');
    }
}
