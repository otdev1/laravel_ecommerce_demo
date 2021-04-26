<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    use HasFactory;

    protected $table = 'category'; //used to prevent conflict with categories table belonging to voyager

    public function products()
    {
        return $this->belongsToMany('App\Models\Product'); 
        //see https://laravel.com/docs/8.x/eloquent-relationships
    }
}
