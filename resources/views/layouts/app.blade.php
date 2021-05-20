@include('layouts.partials.header')
@include('layouts.partials.notifs')
<div id="layoutSidenav">
    @include('layouts.partials.sidebar')
    <div id="layoutSidenav_content">
        <main>
            @yield('content')
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; CMS {{ date('Y') }}</div>
                </div>
            </div>
        </footer>
    </div>
</div>
@include('layouts.partials.footer')
