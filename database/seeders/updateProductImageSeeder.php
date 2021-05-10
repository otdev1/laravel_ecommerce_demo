<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class updateProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //see automate seeding of one database table column - laravel ecommerce notes
        $products = Product::all();

        foreach ($products as $product) {
            if($product->id != 85 )
                DB::table('products')
                    ->where('id', $product->id)
                    ->update([
                        'image' => 'products\\May2021\\' . $product->slug . '.jpg'
            ]);
        }
    }
}
