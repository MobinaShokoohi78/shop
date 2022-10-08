<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://kit.fontawesome.com/a62aebca0c.js" crossorigin="anonymous"></script>
        <title inertia>{{ config('app.name', 'Laravel') }}</title>

{{--        <link href="/your-path-to-fontawesome/css/fontawesome.css" rel="stylesheet">--}}
{{--        <link href="/your-path-to-fontawesome/css/brands.css" rel="stylesheet">--}}
{{--        <link href="/your-path-to-fontawesome/css/solid.css" rel="stylesheet">--}}

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia

        @env ('local')
            <script src="http://localhost:8080/js/bundle.js"></script>
        @endenv
    </body>
    <script src="{{asset('/js/app.js')}}"></script>
    <script src="https://unpkg.com/mitt/dist/mitt.umd.js"></script>

    {{--    <script src="https://kit.fontawesome.com/a62aebca0c.js" crossorigin="anonymous"></script>--}}

</html>
