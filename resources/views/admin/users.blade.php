@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Uporabniki</h4>
                <span style="position:absolute; width:32px; height: 3px; background-color:#f41256;"></span>
            </div>
            <br>
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Ime</th>
                            <th scope="col">E-naslov</th>
                            <th scope="col">Ustvarjeno</th>
                            <th scope="col">Posodobljeno</th>
                            <th scope="col">Dodaj spletni tečaj</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td><a href="/dashboard/users/{{ $user->id }}" title="Poglej profil">{{ $user->name }}</a></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                        <td><a href="/dashboard/users/{{ $user->id }}/add-course">+</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <form action="/dashboard/users/add" method="GET">
                    @csrf
                    <button class="btn btn-primary" type="submit">Dodaj uporabnika</button>
                    <i>Uporabnika, ki je na novo nakupil tečaj lahko dodate tudi v zavihku <a href="/dashboard/orders"><b>Računi</b></a></i>
                </form>
            </div>
        </div> 
    </div>
</div>
@endsection