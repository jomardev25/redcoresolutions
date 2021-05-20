<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="index.html">{{ config('app.name', 'CMS') }}</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 mr-auto" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar-->
    <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="avatar">
                <i class="fas fa-user fa-fw"></i></a>
             </a>

            <div class="dropdown-menu dropdown-menu-right notification-dropdown">
                <a class="dropdown-item" href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="icon-fa icon-fa-sign-out"></i> Logout
                </a>
            </div>
        </li>
    </ul>
    <form id="logout-form" action="{{ route('logout') }}" method="POST"style="display: none;">
        @csrf
    </form>
</nav>
