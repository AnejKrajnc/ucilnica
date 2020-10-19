@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Kode za popust</h4>
                <span style="position:absolute; width:32px; height: 3px; background-color:#f41256;"></span>
            </div>
            <br>
            @if(session()->has('delete-alert'))
                <div class="alert alert-success">
                    {{ session()->get('delete-alert') }}
                </div>
            @endif
            <div class="panel-body">
                <form action="/dashboard/cupons" method="POST">
                    <div class="form-row">
                        @csrf 
                        <button type="submit" class="btn btn-primary">Dodaj nov kupon</button>
                    </div>
                </form>
                <br>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Koda</th>
                            <th scope="col">Popust</th>
                            <th scope="col">Ustvarjeno</th>
                            <th scope="col">Poteče</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cupones as $cupone)
                        <tr>
                        <th scope="row">{{ $cupone->id }}</th>
                        <td><a href="/dashboard/cupons/{{ $cupone->id }}">{{ $cupone->code }}</a></td>
                        <td>{{ $cupone->discount }}</td>
                        <td>{{ $cupone->added_on }}</td>
                        <td>{{ $cupone->expires }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> 
    </div>
</div>
@endsection