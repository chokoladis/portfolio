@include('inc.header')

    <div class="header-breadcrumbs">
        <div class="container">
            @yield('breadcrumb')
        </div>
    </div>

    @yield('content')
        
@include('inc.footer')
