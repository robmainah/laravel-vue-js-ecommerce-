<nav class="navbar navbar-expand-md navbar-light navbar-laravel fixed-top">
    <div class="container-fluid">
        <div id="menu_toggle">
					<span></span>
					<span></span>
					<span></span>
				</div>
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'SpaceX') }}
        </a>
            <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit(); localStorage.removeItem('userInfo')">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>

    </div>
</nav>
{{-- <style scoped>
@media (max-width: 767px) {
	.navbar-nav {
		flex-direction: initial;
	}
	.navbar-expand-md .navbar-nav .nav-link {
		padding-right: 0.5rem;
		padding-left: 0.5rem;
	}
}
</style> --}}
