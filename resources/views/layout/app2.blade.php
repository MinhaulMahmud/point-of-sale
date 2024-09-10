<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>X-Bakery</title>
    <link rel="icon" type="image/x-icon" href="{{asset('/favicon.ico')}}" />
    <link href="{{asset('other-assets/css/bootstrap.css')}}" rel="stylesheet" />
    <link href="{{asset('other-assets/css/animate.min.css')}}" rel="stylesheet" />
    <link href="{{asset('other-assets/css/fontawesome.css')}}" rel="stylesheet" />
    <link href="{{asset('other-assets/css/style.css')}}" rel="stylesheet" />
    <link href="{{asset('other-assets/css/toastify.min.css')}}" rel="stylesheet" />
    <script src="{{asset('other-assets/js/toastify-js.js')}}"></script>
    <script src="{{asset('other-assets/js/axios.min.js')}}"></script>
    <script src="{{asset('other-assets/js/config.js')}}"></script>
</head>

<body>

<div id="loader" class="LoadingOverlay d-none">
<div class="Line-Progress">
    <div class="indeterminate"></div>
</div>
</div>

<div>
    @yield('content')
</div>

<script src="{{asset('other-assets/js/jquery.min.js')}}"></script>

<script src="{{asset('other-assets/js/bootstrap.bundle.js')}}"></script>

</body>
</html>