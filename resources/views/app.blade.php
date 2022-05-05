<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

    @routes
    <script src="{{ mix('/js/app.js') }}" defer></script>
</head>
<body data-layout="vertical" data-sidebar="dark">
    @inertia
</body>
</html>
