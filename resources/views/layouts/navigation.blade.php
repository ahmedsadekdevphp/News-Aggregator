<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <x-application-logo class="d-inline-block align-top" />
        </a>

        <!-- Hamburger Button for Mobile -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto">
                <!-- Dashboard Link -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        {{ __('Dashboard') }}
                    </a>
                </li>

            </ul>

            <!-- Settings Dropdown -->
            <ul class="navbar-nav  ms-auto pull-right">
                <!-- User Profile -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a>
                        <div class="dropdown-divider"></div>
                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Responsive Menu -->
<div class="d-lg-none bg-light border-top">
    <div class="container">
        <div class="py-2">
            <a class="d-block text-decoration-none py-1 {{ request()->routeIs('dashboard') ? 'font-weight-bold' : '' }}"
                href="{{ route('dashboard') }}">
                {{ __('Dashboard') }}
            </a>

            <a class="d-block text-decoration-none py-1" href="{{ route('profile.edit') }}">
                {{ __('Profile') }}
            </a>
            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link text-decoration-none py-1">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</div>
