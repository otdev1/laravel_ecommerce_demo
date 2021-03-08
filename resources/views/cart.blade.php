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
                                <a href="{{ route('shop.show', $item->model->slug) }}"><img src="{{ asset('images/products/'.$item->model->slug.'.jpg') }}" alt="item" class="cart-table-img"></a>
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
                                    <form action="#" method="POST">
                                    
                                        <button type="submit" class="cart-options">Save for Later</button>
                                    </form>
                                </div>
                                <div>
                                    <select class="quantity" data-id="a7344b0686757682845e6325440cbc15" data-productQuantity="10">
                                    <option selected>1</option>
                                    <option >2</option>
                                    <option >3</option>
                                    <option >4</option>
                                    <option >5</option>
                                    </select>
                                </div>
                                <div>{{ $item->model->presentPrice() }}</div>
                            </div>
                        </div>
                        <!-- end cart-table-row -->

                    @endforeach

                    <!--<div class="cart-table-row">
                        <div class="cart-table-row-left">
                            <a href="https://laravelecommerceexample.ca/shop/phone-8"><img src="https://laravelecommerceexample.ca/storage/products/dummy/phone-8.jpg" alt="item" class="cart-table-img"></a>
                            <div class="cart-item-details">
                                <div class="cart-table-item"><a href="https://laravelecommerceexample.ca/shop/phone-8">Phone 8</a></div>
                                <div class="cart-table-description">16GB, 5.8 inch screen, 4GHz Quad Core</div>
                            </div>
                        </div>
                        <div class="cart-table-row-right">
                            <div class="cart-table-actions">
                                <form action="https://laravelecommerceexample.ca/cart/a7344b0686757682845e6325440cbc15" method="POST">
                                <input type="hidden" name="_token" value="mgi9K8sy5HNLzxHcD88SLTGtl1LBWtsbKxnUElAW">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="cart-options">Remove</button>
                                </form>
                                <form action="https://laravelecommerceexample.ca/cart/switchToSaveForLater/a7344b0686757682845e6325440cbc15" method="POST">
                                <input type="hidden" name="_token" value="mgi9K8sy5HNLzxHcD88SLTGtl1LBWtsbKxnUElAW">
                                <button type="submit" class="cart-options">Save for Later</button>
                                </form>
                            </div>
                            <div>
                                <select class="quantity" data-id="a7344b0686757682845e6325440cbc15" data-productQuantity="10">
                                <option selected>1</option>
                                <option >2</option>
                                <option >3</option>
                                <option >4</option>
                                <option >5</option>
                                </select>
                            </div>
                            <div>$826.67</div>
                        </div>
                    </div>-->
                    <!-- end cart-table-row -->
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
                    Shipping is free because we’re awesome like that. Also because that’s additional stuff I don’t feel like figuring out :).
                </div>
                <div class="cart-totals-right">
                    <div>
                        Subtotal <br>
                        Tax (13%)<br>
                        <span class="cart-totals-total">Total</span>
                    </div>
                    <div class="cart-totals-subtotal">
                        $826.67 <br>
                        $107.47 <br>
                        <span class="cart-totals-total">$934.14</span>
                    </div>
                </div>
                </div>
                <!-- end cart-totals -->
                <div class="cart-buttons">
                <a href="https://laravelecommerceexample.ca/shop" class="button">Continue Shopping</a>
                <a href="https://laravelecommerceexample.ca/checkout" class="button-primary">Proceed to Checkout</a>
                </div>
                <h3>You have no items Saved for Later.</h3>

            @else

                <h3>No items in Cart</h3>
                
                <div class="spacer"></div>
                <a href="{{ route('shop.index') }}" class="button">Continue Shopping</a>
                <div class="spacer"></div>

            @endif

        </div>

    </div> <!-- end cart-section -->

    {{--@include('partials.might-like')--}}

    @include('partials.custom-might-like')


@endsection

@section('extra-js')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        (function(){
            const classname = document.querySelectorAll('.quantity')

            Array.from(classname).forEach(function(element) {
                element.addEventListener('change', function() {
                    const id = element.getAttribute('data-id')
                    const productQuantity = element.getAttribute('data-productQuantity')

                    axios.patch(`/cart/${id}`, {
                        quantity: this.value,
                        productQuantity: productQuantity
                    })
                    .then(function (response) {
                        // console.log(response);
                        window.location.href = '{{ route('cart.index') }}'
                    })
                    .catch(function (error) {
                        // console.log(error);
                        window.location.href = '{{ route('cart.index') }}'
                    });
                })
            })
        })();
    </script>

    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
