<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;

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
        //dd(Cart::content()); 

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
        $duplicates = Cart::search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->id === $product->id;
        }); //$product is the current object to be checked 

        if ($duplicates->isNotEmpty()) {
            return redirect()->route('cart.index')->with('success_message', 'Item is already in your cart!');
        }

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
        //return $request->all();

        /*prevents values less than 1 or greater than 5 from being process to update the cart*/
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|between:1,5'
        ]);

        if ($validator->fails()) {
            session()->flash('errors', collect(['Quantity must be between 1 and 5.']));
            return response()->json(['success' => false], 400);
        }

        // if ($request->quantity > $request->productQuantity) {
        //     session()->flash('errors', collect(['We currently do not have enough items in stock.']));
        //     return response()->json(['success' => false], 400);
        // }


        Cart::update($id, $request->quantity);

        session()->flash('success_message', 'Quantity was updated successfully!');
        return response()->json(['success' => true]);
        /*since the request made to the route which calls the update function is an ajax(axios) request
          the response sent in JSON format*/
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

    /**
     * Switch item for shopping cart to Save for Later.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function switchToSaveForLater($id)
    {
        $item = Cart::get($id); //retrieve item with id of $id

        Cart::remove($id); //remove item with id of $id from default instance of cart object

        $duplicates = Cart::instance('saveForLater')->search(function ($cartItem, $rowId) use ($id) {
            return $rowId === $id;
        });
        /*saveForLater is another instance of the cart object, the 'default' is the default instance of the cart
          object see customnav.blade.php
          */

        if ($duplicates->isNotEmpty()) {
            return redirect()->route('cart.index')->with('success_message', 'Item is already Saved For Later!');
        }

        Cart::instance('saveForLater')->add($item->id, $item->name, 1, $item->price)
            ->associate('App\Models\Product');

        return redirect()->route('cart.index')->with('success_message', 'Item has been Saved For Later!');
    }

}
