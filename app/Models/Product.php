<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //use HasFactory; //see productfactory.php for fields associated with the product model

    // public function asDollars($value) {
    //     if ($value<0) return "-".asDollars(-$value);
    //     return '$' . number_format($value, 2);
    // }

    public function presentPrice()
    {
        //return money_format('$%i', $this->price / 100); 
        /*%i is the placeholder for the dollar amount 
          money_format function does not exist on all OSes, windows is 1 of them 
          see https://stackoverflow.com/questions/21507977/fatal-error-call-to-undefined-function-money-format#:~:text=this%20function%20available.-,The%20function%20money_format()%20is%20only%20defined%20if%20the%20system,()%20is%20undefined%20in%20Windows.&text=It%20has%20been%20pointed%20out,comment%20or%20Learner%20Student's%20answer). */
    
          return '$' . number_format($this->price, 2);
    }

    /*this function is a local scope 
      Local scopes allow you to define common sets of query constraints 
      ,in this case inRandomOrder, that you may easily re-use throughout your application.
      see https://laravel.com/docs/8.x/eloquent#query-scopes */
    public function scopeMightAlsoLike($query)
    {
        return $query->inRandomOrder()->take(4);
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
        //see https://laravel.com/docs/8.x/eloquent-relationships
    }

}
