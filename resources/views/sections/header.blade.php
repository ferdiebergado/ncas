    <nav class="navbar is-fixed-top is-light" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item has-text-weight-bold" href="{{ route('home') }}">
                NCAS
            </a>

            <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navMenu">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navMenu" class="navbar-menu">
            <div class="navbar-start">

            </div>

            <div class="navbar-end">

                <a class="navbar-item">
                    Documentation
                </a>

                @auth

                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        More
                    </a>

                    <div class="navbar-dropdown">
                        <a class="navbar-item">
                            User Management
                        </a>
                        <hr class="navbar-divider">
                        <a class="navbar-item">
                            Report an issue
                        </a>
                    </div>
                </div>

                @endauth

                <!-- Authentication Links -->
                @guest
                <div class="navbar-item">
                    <a class="button is-light" href="{{ route('login') }}">{{ __('Login') }}</a>
                </div>
                @if (Route::has('register'))
                <div class="navbar-item">
                    <a class="button is-primary" href="{{ route('register') }}">{{ __('Register') }}</a>
                </div>
                @endif
                @else
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="navbar-dropdown">
                        <a class="navbar-item">{{ __('Profile') }}</a>
                        <hr class="navbar-divider">
                        <a class="navbar-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
