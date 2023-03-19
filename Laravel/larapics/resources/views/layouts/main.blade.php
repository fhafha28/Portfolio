<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title', 'Larapics')</title>

{{--    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Varela+Round">--}}
{{--    <!-- Bootstrap -->--}}
{{--    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">--}}
{{--    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">--}}
{{--    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">--}}
{{--    @stack('styles')--}}
</head>

<body>
Nav bar will be here
@yield('content')
@yield('create')
@yield('show')
</body>


