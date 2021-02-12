<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>GetCarrier</title>

    @if (trim($__env->yieldContent('css')))@yield('css')@endif
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<section class="page-form">
    <div class="page-form__wrapper">
        @if (trim($__env->yieldContent('content')))@yield('content')@endif
    </div>
</section>
<footer class="page-form__footer">
    <div class="container">
        <div class="page-form__footer-inner">
            <div class="page-form__footer-list">
                <a href="#" class="page-form__footer-link">Privacy Policy</a>
                <a href="#" class="page-form__footer-link">Terms and Conditions</a>
                <a href="#" class="page-form__footer-link">Do Not Sell My Info</a>
                <a href="#" class="page-form__footer-link">Join Our Network</a>
            </div>
        </div>
    </div>
</footer>
<script src="{{ asset('js/app.js') }}"></script>
@if (trim($__env->yieldContent('js')))@yield('js')@endif
</body>
</html>