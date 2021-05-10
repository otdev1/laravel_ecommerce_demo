@extends('layout')

@section('title', $product->name)

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    <!--<div class="breadcrumbs">
        <div class="breadcrumbs-container container">
            <div>
                <a href="/">Home</a>
                <i class="fa fa-chevron-right breadcrumb-separator"></i>
                {{--<span><a href="/shop">Shop</a></span>--}}
                <span><a href="{{ route('shop.index') }}">Shop</a></span>
                <i class="fa fa-chevron-right breadcrumb-separator"></i>
                <span>{{--$product->name--}}</span>
            </div>
            <div>
                {{--@include('partials.search')--}}
            </div>
        </div>
    </div>-->

    @component('components.breadcrumbs')
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span><a href="/shop">Shop</a></span>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>{{ $product->name }}</span>
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

    <div class="product-section container">
        <div>
            <div class="product-section-image">
                <img src="{{ asset('storage/'.$product->image) }}" alt="product" class="active" id="currentImage">
                <!--storage/app/public/products-->
                {{--<img src="{{ asset('images/products/'.$product->slug.'.jpg') }}" alt="product" class="active" id="currentImage">--}}
                <!--the slug and the image name of each product is the same-->
            </div>
            <div class="product-section-images">
                <div class="product-section-thumbnail selected">
                    <img src="" alt="product">
                </div>

                {{--@if ($product->images)
                    @foreach (json_decode($product->images, true) as $image)
                    <div class="product-section-thumbnail">
                        <img src="{{ productImage($image) }}" alt="product">
                    </div>
                    @endforeach
                @endif--}}
            </div>
        </div>
        <div class="product-section-information">
            <h1 class="product-section-title">{{ $product->name }}</h1>
            <div class="product-section-subtitle">{{ $product->details }}</div>
            <div>{{--!! $stockLevel !!--}}</div>
            <div class="product-section-price">{{ $product->presentPrice() }}</div>

            <p>
                {{-- $product->description --}}
                {!! $product->description !!}
                {{-- see https://laravel.com/docs/8.x/blade#displaying-unescaped-data --}}
            </p>

            <p>&nbsp;</p>

            {{--@if ($product->quantity > 0)
                <form action="{{ route('cart.store', $product) }}" method="POST">
                    {{ csrf_field() is deprecated }}
                    @csrf
                    <button type="submit" class="button button-plain">Add to Cart</button>
                </form>
            @endif--}}
            
            <!--form element must be used instead of anchor element since cart.store 
                is a post route see web.php-->
            {{--<form action="{{ route('cart.store') }}" method="POST">
                    {{csrf_field() is deprecated}}
                    @csrf
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <input type="hidden" name="name" value="{{ $product->name }}">
                    <input type="hidden" name="price" value="{{ $product->price }}">
                    <button type="submit" class="button button-plain">Add to Cart</button>
            </form>--}}
            
            <!--form element must be used instead of anchor element since cart.store 
                is a post route see web.php-->
            <form action="{{ route('cart.store', $product) }}" method="POST">
                    {{--csrf_field() is deprecated--}}
                    @csrf
                    <button type="submit" class="button button-plain">Add to Cart</button>
            </form>   

        </div>
    </div> <!-- end product-section -->

    {{--@include('partials.might-like')--}}

    @include('partials.custom-might-like')

@endsection

@section('extra-js')
    <script>
        (function(){
            const currentImage = document.querySelector('#currentImage');
            const images = document.querySelectorAll('.product-section-thumbnail');

            images.forEach((element) => element.addEventListener('click', thumbnailClick));

            function thumbnailClick(e) {
                currentImage.classList.remove('active');

                currentImage.addEventListener('transitionend', () => {
                    currentImage.src = this.querySelector('img').src;
                    currentImage.classList.add('active');
                })

                images.forEach((element) => element.classList.remove('selected'));
                this.classList.add('selected');
            }

        })();
    </script>

    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>

@endsection
