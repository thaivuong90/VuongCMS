<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h3>Dashboard! {{ auth()->user()->name }} {{ auth()->user()->system->name }}</h3>
    <a href="{{ route('system.logout') }}">Logout</a>
</body>
</html>