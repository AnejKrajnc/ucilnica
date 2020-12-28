@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Uporabniki - Dodaj novega uporabnika</h4>
                <span style="position:absolute; width:32px; height: 3px; background-color:#f41256;"></span>
            </div>
            <br>
            <div class="panel-body">
                <form action="/dashboard/users/add" method="POST">
                    @csrf
                    <div class="form-row">
                        <label for="ime">Ime in priimek:</label>
                        <input type="text" class="form-control" name="ime" id="ime">
                    </div>
                    <div class="form-row">
                        <label for="uporabniskoime">Uporabniško ime:</label>
                        <input type="text" class="form-control" name="uporabnisko" id="uporabniskoime">
                    </div>
                    <div class="form-group">
                        <label for="tecaji">Izberite spletne tečaje (ob izbiri večih tečajev držite tipko Ctrl ali Shift):</label>
                        <select name="tecaji[]" class="form-control" id="tecaji" multiple>
                            <option disabled selected>Izberite tečaje</option>
                            @foreach ($tecaji as $tecaj)
                                <option value="{{ $tecaj->id }}">{{ $tecaj->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <br>
                    <button class="btn btn-primary" type="submit">Dodaj!</button>
                    <!--<i>Uporabnika, ki je na novo nakupil tečaj lahko dodate tudi v zavihku <a href="/dashboard/orders"><b>Računi</b></a></i> -->
                </form>
            </div>
        </div> 
    </div>
</div>
@endsection