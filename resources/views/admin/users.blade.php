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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td><a class="user-link" data-userid="{{ $user->id }}" title="Poglej profil" style="cursor: pointer;">{{ $user->name }}</a></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <form action="javascript:void(0);">
                    @csrf
                    <button class="btn btn-primary add-newuser" type="submit">Dodaj uporabnika</button>
                    <i>Uporabnika, ki je na novo nakupil tečaj lahko dodate tudi v zavihku <a href="/dashboard/orders"><b>Računi</b></a></i>
                </form>
            </div>
        </div> 
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Dodajanje novega tečaja</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Nalagam...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Zapri</button>
          <button type="button" class="btn btn-primary">Shrani spremembe</button>
        </div>
      </div>
    </div>
  </div>
@endsection