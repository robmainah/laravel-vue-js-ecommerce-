<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <h1>welcome</h1>
                {{-- <img src="{{ asset('posts/2.jpeg') }}" width="440px" alt=""> --}}
                <img src="{{ asset('storage/posts/2.jpeg') }}" width="240px" alt="">
            </div>
        </div>
    </body>
</html>
