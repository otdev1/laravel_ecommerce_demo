<div class="breadcrumbs">
    <div class="breadcrumbs-container container">
        <div>
            {{$slot}} {{--injects content within component directive see shop.blade.php
                           see https://laravel.com/docs/8.x/blade#components--}}
        </div>
        <div>
            {{--@include('partials.search')--}}
        </div>
    </div>
</div> <!-- end breadcrumbs -->
