<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultipleImagesToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('images')->nullable()->after('image');
            /*  difference between $table->string and $table->text see
                https://stackoverflow.com/questions/28519174/difference-between-table-stringsome-text-table-textsome-text-in 
                https://laravel.com/docs/5.0/schema

                $table->text is used here since the uri for each image is stored in array in the images
                column, $table->string cannot be used because it is of type VARCHAR which is limited to 255 characters
            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('images');
        });
    }
}
