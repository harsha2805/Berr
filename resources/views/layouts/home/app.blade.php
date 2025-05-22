<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title> BERR | @yield('title') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="icon" href="{{asset('/public/images/icons/icon-2.webp')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('public/css/home/navbar.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/home/footer.css')}}">
    @stack('styles')

</head>

<body>
    @include('layouts.home.navbar')
    @yield('content')
    @include('layouts.home.footer')

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('public/js/home/navbar.js')}}"></script>
    <script>
        AOS.init();
    </script>
    @yield('scripts')
</body>

</html>