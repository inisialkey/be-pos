<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="/">POS Resto</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item dropdown">
                <a href="/" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('/') ? 'active' : '' }}'>
                        <a class="nav-link" href="/">General Dashboard</a>
                    </li>
                </ul>
            </li>
            <li class="menu-header">Pages</li>
            <li class="nav-item dropdown {{ Request::is('dashboard-general-dashboard-auth') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="far fa-user"></i> <span>Auth</span></a>
                <ul class="dropdown-menu">
                    @auth
                        <li class="{{ Request::is('forgot-password') ? 'active' : '' }}">
                            <a href="{{ url('forgot-password') }}">Forgot Password</a>
                        </li>
                        <li class="{{ Request::is('reset-password') ? 'active' : '' }}">
                            <a href="{{ url('reset-password') }}">Reset Password</a>
                        </li>
                    @else
                        <li class="{{ Request::is('login') ? 'active' : '' }}">
                            <a href="{{ url('login') }}">Login</a>
                        </li>
                        <li class="{{ Request::is('register') ? 'active' : '' }}">
                            <a href="{{ url('register') }}">Register</a>
                        </li>
                    @endauth

                </ul>
            </li>
            <li class="nav-item dropdown {{ Request::is('features*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-bicycle"></i> <span>Features</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('features/categories*') ? 'active' : '' }}">
                        <a class="nav-link" href="/features/categories">Categories</a>
                    </li>
                    <li class="{{ Request::is('features/sub-categories*') ? 'active' : '' }}">
                        <a class="nav-link" href="/features/sub-categories">SubCategory</a>
                    </li>
                    <li class="{{ Request::is('features/products*') ? 'active' : '' }}">
                        <a class="nav-link" href="/features/products">Products</a>
                    </li>
                    <li class="{{ Request::is('features/users*') ? 'active' : '' }}">
                        <a class="nav-link" href="/features/users">Users</a>
                    </li>
                </ul>
            </li>
        </ul>

        {{-- <div class="hide-sidebar-mini mt-4 mb-4 p-3">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a>
        </div> --}}
    </aside>
</div>
