@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Nov uporabnik</h4>
                <span style="position:absolute; width:32px; height: 3px; background-color:#f41256;"></span>
            </div>
            <br>
            <div class="panel-body">
               <i>Ustvarjen nov uporabnik</i>
               <p>Ime in priimek: <b>{{ $name }}</b><br>
                  Uporabniško ime: <b>{{ $username }}</b><br>
                  Geslo: <b>{{ $password }}</b>
            </p>
            </div>
        </div> 
    </div>
</div>
@endsection