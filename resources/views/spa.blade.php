<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script>
        var API_URL = '{{ env('API_URL') }}';
    </script>

<!-- Styles -->
<link href="{{ mix('css/app.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://rsms.me/inter/inter.css">
</head>
<body>
    <div id="app" class="h-screen flex flex-col">
        <app></app>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    <!-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.0.1/dist/alpine.js" defer></script> -->
</body>
</html>
