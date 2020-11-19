<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{asset('js/jquery.js')}}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/font-awesome/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Custom Script load for current view -->
    @stack('scripts')

</head>
<body>
<div class="page-container mx-auto container-fluid">
    <div class="page-without-footer row">

        <!-- Left Sidebar -->
    @include('main_layout_components.left-sidebar')
    <!--// Left Sidebar -->

        <!-- Main Dynamic Content -->
        <main class="page-content-wrapper col-8">

            @include('messages.success_and_error_messages')  <!-- success/error messages for creating posts, login or register ... -->

            @yield('content')
        </main>
        <!--// Main Dynamic Content -->

        <!-- Right Sidebar -->
    @include('main_layout_components.right-sidebar')
    <!--// Right Sidebar -->

    </div>

    <!-- footer here -->
@include('main_layout_components.footer')
<!-- // footer here -->
</div>
</body>
</html>
