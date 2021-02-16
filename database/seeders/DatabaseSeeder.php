<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\Product::factory(10)->create(); 
        /*creates/persists 10 records containing random data in each field of the Product model 
          to the Products table see product.php and productfactory.php*/
    }
}
