<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SpaceX') }}</title>

    <!-- Styles -->
    @include('layouts.head-links')
    <style>
.moveInUp-enter-active{
  animation: fadeIn 0.7s ease-in;
}
@keyframes fadeIn{
  0%{
    opacity: 0;
  }
  50%{
    opacity: 0.5;
  }
  100%{
    opacity: 1;
  }
}

@media (max-width: 767px) {
	.navbar-nav {
		flex-direction: initial;
	}
	.navbar-expand-md .navbar-nav .nav-link {
		padding-right: 0.5rem;
		padding-left: 0.5rem;
	}
}
</style>
</head>

<body>
    <div id="wrapper">
{{-- {{ Auth::user() }} --}}
        {{-- <div id="customerApp">
            @guest
                <Myheader :carts="carts, totals, brand, hideCats, userLoggedIn" @logged-in="userLoginStatus" ></Myheader>

                    <div id="ind-cont" style="min-height: 427px">
                        <transition name="moveInUp">
                            <router-view :products="products,categories,carts,selectedProduct,totals"
                            @product-selected="updateProdSelected" @add-to-cart="updateCart"
                            @remove-from-cart="removeCart" @active-category="activeCategory" @cart-empty="emptyCart"
                            @logged-in="userLoginStatus" @hide-cat="hideCategory" @changeqty="updateQty"></router-view>
                        </transition>
                    </div>

                <Myfooter :brand="brand"></Myfooter>
            @endguest

            @auth
                @if (Auth::user()->roles === 1)
                    <Myheader :carts="carts, totals, brand, hideCats, userLoggedIn" @logged-in="userLoginStatus" ></Myheader>

                    <div id="ind-cont" style="min-height: 427px">
                        <transition name="moveInUp">
                            <router-view :products="products,categories,carts,selectedProduct,totals"
                            @product-selected="updateProdSelected" @add-to-cart="updateCart"
                            @remove-from-cart="removeCart" @active-category="activeCategory" @cart-empty="emptyCart"
                            @logged-in="userLoginStatus" @hide-cat="hideCategory" @changeqty="updateQty"></router-view>
                        </transition>
                    </div>

                    <Myfooter :brand="brand"></Myfooter>
                @endif
            @endauth

        </div> --}}

        <div id="adminApp" :class="modalopen">
            {{-- @auth --}}
                {{-- @if (Auth::user()->roles >= 3) --}}
                    <Adminsidebar></Adminsidebar>
                    @include ('layouts.nav')
                    <div id="page-content-wrapper">
                        <div style="min-height: 427px;top: 4rem;position: relative;">
                            <transition name="moveInUp">
                                <!-- {{-- <dashboard/> --}} -->
                                <router-view></router-view>
                            </transition>


                        </div>
                    </div>


                {{-- @endif --}}
            {{-- @endauth --}}
        </div>
    </div>

    <!-- Scripts -->
    @include ('layouts.footer-links')
    {{-- <script src="https://www.paypal.com/sdk/js?client-id=sb"></script>
    <script>paypal.Buttons().render('body');</script> --}}
</body>
</html>
