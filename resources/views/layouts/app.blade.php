<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <script type="text/javascript">
        altApp = {
            tax_rate: "{{config('custom.tax_rate', 13)}}"
        };
    </script>
    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>

    <title>{{config('app.name', 'AltHealth')}}</title>
</head>
<body>
    @include('inc.navbar')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @include('inc.messages')
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
