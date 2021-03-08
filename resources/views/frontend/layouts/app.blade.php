<!DOCTYPE html>
<head>
    @include('frontend.layouts.head')
</head>
<body>
<!-- Wrapper -->
<div id="wrapper">
    @include('frontend.layouts.header')

    @yield('content')

    @include('frontend.layouts.footer')

    @include('frontend.layouts.foot')
</div>
<!-- Wrapper / End -->
</body>
</html>
