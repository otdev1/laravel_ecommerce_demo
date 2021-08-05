<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    use HasFactory;

    protected $table = 'category_product';

    protected $fillable = ['product_id', 'category_id'];
    /*makes product_id and category_id columns in the categoryproduct table mass assignable i.e 
      many values can added to these tables at once*/
}
