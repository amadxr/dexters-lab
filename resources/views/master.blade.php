<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dexter's Laboratory</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-dark bg-dark navbar-expand-lg mb-3">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand mb-0 h1" href="{{ route('home') }}">Dexter's Laboratory</a>
                </div>
                <div class="d-flex justify-content-end">
                    <form class="form-inline">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        <button type="submit" class="btn btn-outline-success mr-sm-2">Search</button>
                    </form>
                    <a class="btn btn-success" href="{{ route('create') }}" role="button">Create a new experiment</a>
                </div>
            </div>
        </nav>
        @yield('content')
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
