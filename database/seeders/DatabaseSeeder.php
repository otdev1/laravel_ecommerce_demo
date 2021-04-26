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
        // \App\Models\Product::factory(10)->create(); 
        /*creates/persists 10 records containing random data in each field of the Product model 
          to the Products table see product.php and productfactory.php*/

          $this->call([
            CategoryTableSeeder::class,
            ProductsTableSeeder::class,
        ]);
        /*Within the DatabaseSeeder class, you may use the call method to execute 
          additional seed classes. Using the call method allows you to break up your 
          database seeding into multiple files so that no single seeder class becomes 
          too large. The call method accepts an array of seeder classes 
          see https://laravel.com/docs/8.x/seeding#calling-additional-seeders*/

    }
}
