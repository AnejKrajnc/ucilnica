<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        header {
            position: relative;
            margin: 0;
            width: 100%;
            height: 100px;
            background-color: #f41256;
        }
        .outer {
            width: 100%;
            height: auto;
            margin-top: 15px;
            text-align: center;
        }
        .container {
            position: relative;
            display: inline-block;
            padding: 20px;
            width: 350px;
            height: 250px;
            border-radius: 10px;
            text-align: left;
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <header></header>
    <div class="outer">
    <div class="container">
        <p>Uporabniško ime: <b>{{ $username }}</b></p>
        <p>Geslo: <b>{{ $password }}</b></p>
        <br><br><br>
        <p>Ob prvi prijavi izberite v glavnem meniju <b>moj profil</b> in spremenite geslo</p>
    </div>
    </div>
</body>
</html>