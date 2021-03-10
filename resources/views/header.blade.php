<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto w3-button w3-teal w3-xlarge" type="button"
        data-toggle="sidebar-show">
        &#9776;
    </button>
    <a class="navbar-brand" href="{{ url('/') }}">
        <img class="navbar-brand-full" src="{{ url('/images/logo.png') }}" width="60" height="30" alt="BdREN Logo">
        <img class="navbar-brand-minimized" src="{{ url('/images/logo.png') }}" width="60" height="30"
            alt="BdREN Logo">
    </a>
    {{-- <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button"
        data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button> --}}
    <button class="navbar-toggler sidebar-toggler d-md-down-none w3-button w3-teal w3-xlarge" type="button"
        data-toggle="sidebar-lg-show">&#9776;</button>

    <ul class="nav navbar-nav ml-auto">

        <li class="nav-item dropdown">
            <a class="nav-link" style="margin-right: 10px" data-toggle="dropdown" href="#" role="button"
                aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#">
                    <i class="fa fa-user"></i> Profile</a>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-shield"></i>Change Password</a>
                <a href="{{ url('/logout') }}" class="dropdown-item btn btn-default btn-flat">
                    <i class="fa fa-lock"></i>Logout
                </a>
                <form id="logout-form" action="#" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</header>
