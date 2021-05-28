<header class="with-background">
    <div class="top-nav container">
        <div class="top-nav-left">
            <div class="logo">Laravel Ecommerce Demo</div>

                {{ menu('main', 'partials.menus.v-main') }}
                {{-- the menu is referenced as main such that it is configurable in voyager as this reference 
                    see - http://127.0.0.1:8000/admin/menus/2/builder 
                    the template for this menu is defined in views/partials/menus/v-main
                    see https://voyager-docs.devdojo.com/core-concepts/menus-and-menu-builder 
                --}}

            </div>

            <div class="top-nav-right">
                @include('partials.menus.main-right')
            </div>
        
            {{-- <ul>
                    <li><a href="{{ route('shop.index') }}">Shop</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="{{ route('cart.index') }}">Cart 
                            @if( Cart::instance('default')->count() > 0 ) 
                                <!--show cart item count badge if cart is not empty -->
                                <span class="cart-count"><span>{{ Cart::instance('default')->count() }}</span></span>
                                <!--see switchtosaveforlater function in cartcontroller for other instance
                                    of the cart object-->
                            @endif
                        </a>
                    </li>
                </ul>--}}
    </div> <!-- end top-nav -->
</header>
