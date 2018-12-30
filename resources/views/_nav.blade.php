@guest
    <!-- Guest Menu Items-->
    <li class="nav-item">
        <a class="nav-link {{ is_active('login') ? 'active' : '' }}" href="{{ url('login') }}">
            <i class="fas fa-sign-in-alt"></i> {{ __('app.nav.login') }}
        </a>
    </li>
    @if(config('auth.registration'))
        <li class="nav-item {{ is_active('register') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('register') }}">
                <i class="fas fa-arrow-circle-right"></i> {{ __('app.nav.register') }}
            </a>
        </li>
    @endif
@elseguest
    <!-- Personal Menu Items -->
    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle {{ is_active('auth') ? 'active' : '' }}" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <i class="fas fa-user"></i> {{ user_name() }} <span class="caret"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item {{ is_active('profile') ? 'active' : '' }}" href="{{ url('profile') }}">
                <i class="fas fa-user"></i> {{__('app.nav.profile')}}
            </a>
            <a class="dropdown-item {{ is_active('auth/password/change') ? 'active' : '' }}" href="{{ url('auth/password/change') }}">
                <i class="fas fa-key"></i> {{__('app.nav.change_password')}}
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item {{ is_active('logout') ? 'active' : '' }}" href="{{ url('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> {{ __('app.nav.logout') }}
            </a>
            <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </li>
@endguest