<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use TCG\Voyager\Http\Controllers\VoyagerBreadController as BaseVoyagerBreadController;
use App\Models\Product;

class ImageRemoverController extends BaseVoyagerBreadController
{
    public function delete_value($id)
    {
    
        $product = Product::find($id);

        if (isset($product->id)) {
                if (Storage::disk(config('voyager.storage.disk'))->exists($product->image)) {
                    Storage::disk(config('voyager.storage.disk'))->delete($product->image);
                }
            $product->image = '';
            $product->save();
        }

        return back()->with([
            'message'    => "Successfully removed image",
            'alert-type' => 'success',
        ]);
    }
}
