<ul>
    @foreach($items as $menu_item)
        {{--voyager menu item--}} 
        <li>
            <a href="{{ $menu_item->link() }}">
                {{ $menu_item->title }}
                @if ($menu_item->title === 'Cart')
                    <!--show cart item count badge if cart is not empty -->
                    @if (Cart::instance('default')->count() > 0)
                        <span class="cart-count"><span>{{ Cart::instance('default')->count() }}</span></span>
                    <!--see switchtosaveforlater function in cartcontroller for other instance
                            of the cart object-->
                    @endif
                @endif
            </a>
        </li>
    @endforeach
</ul>

{{-- <ul>
    <li><a href="{{ route('shop.index') }}">Shop</a></li>
    <li><a href="#">About</a></li>
    <li><a href="#">Blog</a></li>
    <li><a href="{{ route('cart.index') }}">Cart 
            @if( Cart::instance('default')->count() > 0 ) 
                <!--show cart item count badge if cart is unempty -->
                <span class="cart-count"><span>{{ Cart::instance('default')->count() }}</span></span>
            @endif
        </a>
    </li>
</ul> --}}
