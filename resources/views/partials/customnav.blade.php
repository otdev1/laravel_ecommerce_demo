<header class="with-background">
    <div class="top-nav container">
        <div class="logo">CSS Grid Example</div>
        <ul>
            <li><a href="{{ route('shop.index') }}">Shop</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="{{ route('cart.index') }}">Cart 
                    @if( Cart::instance('default')->count() > 0 ) 
                        <!--show cart item count badge if cart is unempty -->
                        <span class="cart-count"><span>{{ Cart::instance('default')->count() }}</span></span>
                        <!--see switchtosaveforlater function in cartcontroller for other instance
                            of the cart object-->
                    @endif
                </a>
            </li>
        </ul>
    </div> <!-- end top-nav -->
</header>
