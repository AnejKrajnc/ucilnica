<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Spletna učilnica by Nika Soršak | Prijava</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
   <div class="container">
   <div class="row">
   <div class="col-5">
   <div class="card">
   <h2 class="text-center">Prijava</h2>
   <form>
   <div class="form-group">
   <label for="username">Uporabniško ime:</label>
   <input type="text" class="form-control col-8" name="username">
   </div>
   <div class="form-group">
   <label for="password">Geslo:</label>
   <input type="password" class="form-control col-8" name="password">
   </div>
   <button type="submit" class="col-3 btn btn-primary">Prijava</button>
   </form>
   </div>
   </div>
   </div> 
</body>
</html>