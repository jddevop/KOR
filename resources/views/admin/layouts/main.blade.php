<!DOCTYPE html>
<html lang="en">

<head>
   @include('admin.layouts.partials.head')
    @stack('custom-style')
</head>

<body class="mini-sidebar">
    <!-- ===== Main-Wrapper ===== -->
    <div id="wrapper">
        <div class="preloader">
            <div class="cssload-speeding-wheel"></div>
        </div>
        <!-- ===== Top-Navigation ===== -->
        @include('admin.layouts.partials.topbar')
        <!-- ===== Top-Navigation-End ===== -->
        <!-- ===== Left-Sidebar ===== -->
        @include('admin.layouts.partials.sidebar')
        <!-- ===== Left-Sidebar-End ===== -->
        <!-- ===== Page-Content ===== -->
        <div class="page-wrapper">
            @yield('content')
            <!-- ===== Page-Container-End ===== -->
            @include('admin.layouts.partials.footer')
        </div>
        <!-- ===== Page-Content-End ===== -->
    </div>
    <!-- ===== Main-Wrapper-End ===== -->
    <!-- ==============================
        Required JS Files
    =============================== -->
    <!-- ===== jQuery ===== -->
    @include('admin.layouts.partials.scripts')

    {{-- custom scripts --}}
    @stack('custom-scripts')
</body>

</html>
