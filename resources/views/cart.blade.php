@extends('layout')

@section('title', 'Shopping Cart')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Shopping Cart</span>
    @endcomponent

    <div class="cart-section container">
        <div>
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

            @if (Cart::count() > 0)

                <h2>{{ Cart::count() }} item(s) in Shopping Cart</h2>

                <div class="cart-table">
                    @foreach (Cart::content() as $item)
                    
                        <div class="cart-table-row">
                            <div class="cart-table-row-left"> 
                                <!--the item object has a model property, the model in this case is Product which has been assocaited with 
                                    cart model (see cartcontroller and product.php) -->
                                {{-- <a href="{{ route('shop.show', $item->model->slug) }}"><img src="{{ asset('images/products/'.$item->model->slug.'.jpg') }}" alt="item" class="cart-table-img"></a> --}}
                                {{-- <a href="{{ route('shop.show', $item->model->slug) }}"><img src="{{ asset('storage/'.$item->model->image) }}" alt="item" class="cart-table-img"></a> --}}
                                <a href="{{ route('shop.show', $item->model->slug) }}"><img src="{{ productImage($item->model->image) }}" alt="item" class="cart-table-img"></a>
                                <!--see helpers file for definition of productImage-->
                                <div class="cart-item-details">
                                    <div class="cart-table-item"><a href="{{ route('shop.show', $item->model->slug) }}">{{ $item->model->name }}</a></div>
                                    <div class="cart-table-description">{{ $item->model->details }}</div>
                                </div>
                            </div>
                            <div class="cart-table-row-right">
                                <div class="cart-table-actions">
                                    <form action="{{ route('cart.destroy', $item->rowId) }}" method="POST">
                                    <!--rowId of the row which the product is in since one product per row is displayed 
                                        in the cart-->
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="cart-options">Remove</button>
                                    </form>
                                    <form action="{{ route('cart.switchToSaveForLater', $item->rowId) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="cart-options">Save for Later</button>
                                    </form>
                                </div>
                                <div>
                                    <select class="quantity" data-id="{{ $item->rowId }}" data-productQuantity="{{ $item->model->quantity }}">
                                        @for ($i = 1; $i < 6 ; $i++)
                                            <option {{ $item->qty == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor <!--show current quantity value in select box for a specific item-->
                                        {{--
                                            <option {{ $item->qty == 1 ? 'selected' : '' }}>1</option>
                                            <option {{ $item->qty == 2 ? 'selected' : '' }}>2</option>
                                            <option {{ $item->qty == 3 ? 'selected' : '' }}>3</option>
                                            <option {{ $item->qty == 4 ? 'selected' : '' }}>4</option>
                                            <option {{ $item->qty == 5 ? 'selected' : '' }}>5</option>
                                        --}}
                                    </select>
                                </div>
                                <div>{{ presentPrice($item->subtotal) }}</div>
                            </div>
                        </div>
                        <!-- end cart-table-row -->

                    @endforeach

                </div>
                <!-- end cart-table -->
                <a href="#" class="have-code">Have a Code?</a>
                <div class="have-code-container">
                <form action="https://laravelecommerceexample.ca/coupon" method="POST">
                    <input type="hidden" name="_token" value="mgi9K8sy5HNLzxHcD88SLTGtl1LBWtsbKxnUElAW">
                    <input type="text" name="coupon_code" id="coupon_code">
                    <button type="submit" class="button button-plain">Apply</button>
                </form>
                </div>
                <!-- end have-code-container -->
                <div class="cart-totals">
                <div class="cart-totals-left">
                    {{--Shipping is free because we’re awesome like that. Also because that’s additional stuff I don’t feel like figuring out :).--}}
                    Shipping Fee:   n/a
                </div>
                <div class="cart-totals-right">
                    <div>
                        Subtotal <br>
                        Tax (13%)<br>
                        <span class="cart-totals-total">Total</span>
                    </div>
                    <div class="cart-totals-subtotal">
                        {{ presentPrice(Cart::subtotal()) }} <br>
                        {{ presentPrice(Cart::tax()) }}<br>
                        <span class="cart-totals-total">{{ presentPrice(Cart::total()) }}</span>
                    </div>
                </div>
                </div>
                <!-- end cart-totals -->
                <div class="cart-buttons">
                    <a href="{{ route('shop.index') }}" class="button">Continue Shopping</a>
                    <a href="{{ route('checkout.index') }}" class="button-primary">Proceed to Checkout</a>
                </div>

            @else

                <h3>No items in Cart</h3>
                
                <div class="spacer"></div>
                <a href="{{ route('shop.index') }}" class="button">Continue Shopping</a>
                <div class="spacer"></div>

            @endif

            @if (Cart::instance('saveForLater')->count() > 0)

                <h2>{{ Cart::instance('saveForLater')->count() }} item(s) Saved For Later</h2>

                <div class="saved-for-later cart-table">
                    @foreach (Cart::instance('saveForLater')->content() as $item)
                        <div class="cart-table-row">
                            <div class="cart-table-row-left">
                                {{-- <a href="{{ route('shop.show', $item->model->slug) }}"><img src="{{ asset('images/products/'.$item->model->slug.'.jpg') }}" alt="item" class="cart-table-img"></a> --}}
                                <a href="{{ route('shop.show', $item->model->slug) }}"><img src="{{ productImage($item->model->image) }}" alt="item" class="cart-table-img"></a>
                                <!--see helpers file for definition of productImage-->
                                <div class="cart-item-details">
                                    <div class="cart-table-item"><a href="{{ route('shop.show', $item->model->slug) }}">{{ $item->model->name }}</a></div>
                                    <div class="cart-table-description">{{ $item->model->details }}</div>
                                </div>
                            </div>
                            <div class="cart-table-row-right">
                                <div class="cart-table-actions">
                                    <form action="{{ route('saveForLater.destroy', $item->rowId) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="cart-options">Remove</button>
                                    </form>

                                    <form action="{{ route('saveForLater.switchToCart', $item->rowId) }}" method="POST">
                                        @csrf

                                        <button type="submit" class="cart-options">Move to Cart</button>
                                    </form>
                                </div>

                                <div>{{ $item->model->presentPrice() }}</div>
                            </div>
                        </div> <!-- end cart-table-row -->
                    @endforeach

                </div> <!-- end saved-for-later -->

            @else

                <h3>You have no items Saved for Later.</h3>

            @endif

        </div>

    </div> <!-- end cart-section -->

    {{--@include('partials.might-like')--}}

    @include('partials.custom-might-like')


@endsection

{{--@section('extra-js')--}}
    <!--<script src="{{ asset('js/app.js') }}"> /*load app.js from public folder */
        /*invoking function*/-->
@push('scripts')
{{--see 
    stack directive in layout.blade.php
    https://laravel.com/docs/5.8/blade#stacks 
    https://stackoverflow.com/questions/55963663/laravel-custom-javascript-on-blade-is-not-working/55963744
--}}
    <script>
        (function(){
            const classname = document.querySelectorAll('.quantity') 
            /*classname is a node list*/

            /*Array.from(classname).forEach(function(element)*/ 
            document.querySelectorAll(".quantity").forEach(function (element){
                /*array.from() which is an ES6 function is used to convert classname to an array*/
                element.addEventListener('change', function() {
                    const id = element.getAttribute('data-id') //see select element
                    // const productQuantity = element.getAttribute('data-productQuantity')

                    // axios.patch(`/cart/${id}`, {
                    //     quantity: this.value,
                    //     productQuantity: productQuantity
                    // })
                    // .then(function (response) {
                    //     // console.log(response);
                    //     window.location.href = '{{ route('cart.index') }}'
                    // })
                    // .catch(function (error) {
                    //     // console.log(error);
                    //     window.location.href = '{{ route('cart.index') }}'
                    // });

                    axios.patch(`/cart/${id}`, {
                        quantity: this.value //get the quantity of the current row item with an id of id
                    })
                    .then(function (response) {
                        //console.log(response);
                        window.location.href = '{{ route('cart.index') }}' //reload cart page after product quantity is changed
                    })
                    .catch(function (error) {
                        //console.log(error.response);
                        window.location.href = '{{ route('cart.index') }}'
                    });
                    //alert('changed');
                })
            })

        })();
    
    </script>
@endpush

@section('extra-js')
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
