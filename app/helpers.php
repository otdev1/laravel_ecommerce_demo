<?php

    function presentPrice($price)
    {
        //return money_format('$%i', $this->price / 100); 
        /*%i is the placeholder for the dollar amount 
          money_format function does not exist on all OSes, windows is 1 of them 
          see https://stackoverflow.com/questions/21507977/fatal-error-call-to-undefined-function-money-format#:~:text=this%20function%20available.-,The%20function%20money_format()%20is%20only%20defined%20if%20the%20system,()%20is%20undefined%20in%20Windows.&text=It%20has%20been%20pointed%20out,comment%20or%20Learner%20Student's%20answer). */
    
          return '$' . number_format($price, 2);
    }

    function setActiveCategory($category, $output = 'active')
    {
        return request()->category == $category ? $output : '';
    }

    function productImage($path)
    {
        return $path && file_exists('storage/'.$path) ? asset('storage/'.$path) : asset('images/no-image.jpg');
        //if the path to the image is in the products table and the image file exists display it else display no-image.jpg
    }

?>