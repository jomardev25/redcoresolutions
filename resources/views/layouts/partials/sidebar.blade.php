<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Main Navigation</div>
                <a class="nav-link" href="{{ route('songs.index') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-music"></i>
                    </div>
                    Songs
                </a>
                <a class="nav-link" href="{{ route('artists.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-star"></i></div>
                    Artists
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as: {{ auth()->user()->name }}</div>
        </div>
    </nav>
</div>
