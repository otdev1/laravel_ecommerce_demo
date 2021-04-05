<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_product', function (Blueprint $table) {
            $table->id();

            $table->integer('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')
                  ->on('products')->onDelete('cascade'); 
            /*reference to products table
              onDelete('cascade'); simply adds ON DELETE CASCADE rule to the database 
              which specifies that the child data gets deleted when the parent data is deleted.
              see https://stackoverflow.com/questions/43094543/what-does-ondeletecascade-mean*/

            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')
                  ->on('category')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_product');
    }
}
