<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
        {{--<form action="{{ route('create-agreement', 'P-86195515PF812261CBGJ4DJQ') }}" method="POST">--}}
            {{--@csrf--}}

            {{--<input type="submit" value="Subscribe now">--}}
        {{--</form>--}}

        <form action="{{ route('mpesa-payment') }}" method="post">
            @csrf

            <input type="submit" value="Pay Now">
        </form>
    </div>
</body>
</html>
