<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email test</title>
</head>
<body>
    <form method="POST">
        @csrf
        <input type="email" name="email">
        <button type="submit">Potrdi!</button>
    </form>
</body>
</html>