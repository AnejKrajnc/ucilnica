@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-3 col-md-3">
            <h5><b>TVOJ PROFIL</b></h5>
            <span style="position: absolute; width:32px; height: 3px; background-color:#f41256;"></span>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-md-4">
            <br>
            <h5>{{ Auth::user()->name }}</h5>
            <br>
            <h3><b>SPREMEMBA GESLA</b></h3>
        <form action="{{ secure_url('moj-profil') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="inputStaroGeslo">Vpišite staro geslo:</label>
                        <input type="password" class="form-control" name="currentpasswd" id="inputStaroGeslo">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="inputNovoGeslo">Vpišite novo geslo:</label>
                        <input type="password" class="form-control" name="newpasswd" id="inputNovoGeslo">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="inputNovoGesloPotrditev">Potrdite novo geslo:</label>
                        <input type="password" class="form-control" name="verifynewpasswd" id="inputNovoGesloPotrditev">
                    </div>
                    @if(session()->has('message'))
                        @if(session()->get('message')=='Vaše geslo je bilo spremenjeno!')
                        <div class="alert alert-success" role="alert">
                            {{ session()->get('message') }}
                        </div>
                        @else 
                        <div class="alert alert-danger" role="alert"> 
                            {{ session()->get('message') }}
                        </div>
                        @endif
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Spremeni geslo</button>
            </form>
        </div>
        <div class="col-sm-6 col-md-6">
            <br><br><br>
            <h3><b>TVOJI NAKUPLJENI TEČAJI</b></h3>
            <div class="panel panel-default">
                <div class="panel-heading"> </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ime tečaja</th>
                            <th>Datum nakupa tečaja</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (DB::table('order_items')->join('orders', 'orders.id', '=', 'order_items.order_id')->join('items', 'order_items.item_id', '=', 'items.id')->where('orders.customer_id', '=', Auth::user()->customer_id)->select('items.name', 'orders.order_date')->get() as $order)
                        <tr>
                            <th scope="row">{{ $loop->index+1 }}</th>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->order_date }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!--<a href="/nakup"><button class="btn btn-primary">Kupi nov tečaj</button></a> -->
            </div>
        </div>
    </div>
</div>
@endsection