@extends('layout')

@section('title', 'Products')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        {{--<span><a href="/shop">Shop</a></span>
            <span><a href="{{ route('shop.index') }}">Shop</a></span>
        --}}
        <span>Shop</span>
    @endcomponent {{--see https://laravel.com/docs/8.x/blade#components--}}

    <div class="container">
        @if (session()->has('success_message'))
            <div class="alert alert-success">
                {{ session()->get('success_message') }}
            </div>
        @endif

        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="products-section container">
        <div class="sidebar">
            <h3>By Category</h3>
            <ul>
                @foreach ($categories as $category)
                    {{--<li class="{{ setActiveCategory($category->slug) }}"><a href="{{ route('shop.index', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>--}}
                    <li><a href="{{ route( 'shop.index', ['category' => $category->slug] ) }}">{{ $category->name }}</a></li>
                                 {{--add a query to the link for a specific category e.g http://localhost:0000/shop?category=category_name--}}
                @endforeach
            </ul>
        </div> <!-- end sidebar -->
        <div>
            <div class="products-header">
                <h1 class="stylish-heading">{{ $categoryName }}</h1>
                <div>
                    <strong>Price: </strong>
                    <a href="{{ route('shop.index', ['category'=> request()->category, 'sort' => 'low_high']) }}">Low to High</a> |
                    <a href="{{ route('shop.index', ['category'=> request()->category, 'sort' => 'high_low']) }}">High to Low</a>
                </div>
            </div>

            <div class="products text-center">
                {{--@foreach ($products as $product)--}}
                    <!--<div class="product">-->
                        <!--<a href="{{--route('shop.show', $product->slug)--}}"><img src="{{--asset('images/products/'.$product->slug.'.jpg')--}}" alt="product"></a>-->
                        <!--<a href="#"><div class="product-name">{{--$product->name--}}</div></a>-->
                        <!--<a href="{{--route('shop.show', $product->slug)--}}"><div class="product-name">{{--$product->name--}}</div></a>-->
                        <!--<div class="product-price">{{--$product->price--}}</div>-->
                        <!--<div class="product-name">{{--$product->presentPrice()--}}</div>-->
                        <!--see product.php for definition of presetprice()-->
                    <!--</div>-->
                    {{--@endforeach--}}
                @forelse ($products as $product)
                    <div class="product">
                        <a href="{{ route('shop.show', $product->slug) }}"><img src="{{ asset('images/products/'.$product->slug.'.jpg') }}" alt="product"></a>
                        <!--<a href="#"><div class="product-name">{{--$product->name--}}</div></a>-->
                        <a href="{{ route('shop.show', $product->slug) }}"><div class="product-name">{{ $product->name }}</div></a>
                        <!--<div class="product-price">{{--$product->price--}}</div>-->
                        <div class="product-name">{{$product->presentPrice()}}</div>
                        <!--see product.php for definition of presetprice()-->
                    </div>
                @empty
                    <div style="text-align: left">No items found</div>
                @endforelse
                {{--forelse checks if an array exists and loops through it if 
                    not i.e the array is empty it uses the provided else condition.--}}
            </div> <!-- end products -->

            <div class="spacer"></div>
            {{--$products->appends(request()->input())->links()--}}
        </div>
    </div>

@endsection

@section('extra-js')
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
