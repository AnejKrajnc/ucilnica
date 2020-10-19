@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Nakupi</h4>
                <span style="position:absolute; width:32px; height: 3px; background-color:#f41256;"></span>
            </div>
            <br>
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Ime</th>
                            <th scope="col">Priimek</th>
                            <th scope="col">Telefon</th>
                            <th scope="col">E-poštni naslov</th>
                            <th scope="col">Naslov</th>
                            <th scope="col">Kraj</th>
                            <th scope="col">Poštna številka</th>
                            <th scope="col">Status nakupa</th>
                            <th scope="col">Datum nakupa</th>
                            <th scope="col">Skupno</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                        <th scope="row">{{ $order->id ?? '' }}</th>
                        <td>{{ $order->first_name ?? '' }}</td>
                        <td>{{ $order->last_name ?? '' }}</td>
                        <td>{{ $order->phone ?? '' }}</td>
                        <td>{{ $order->email ?? '' }}</td>
                        <td>{{ $order->naslov ?? '' }}</td>
                        <td>{{ $order->kraj ?? '' }}</td>
                        <td>{{ $order->postal ?? '' }}</td>
                        <td>{{ $order->order_status ?? '' }}</td>
                        <td>{{ $order->order_date ?? '' }}</td>
                        <td>{{ $order->totalprice ?? '' }}</td>
                        <td>
                            <form action="/dashboard/endpoints/add-user" method="POST">
                                @csrf
                                @if($order->payment_type == 'predracun' && $order->order_status == 'v obdelavi')
                                    <form action="" method="POST">
                                        @csrf 
                                        <input type="hidden" name="customer_id" value="{{ $order->customer_id }}">
                                        <button type="submit">Dodaj uporabnika</button>
                                    </form>
                                @endif
                            </form>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> 
    </div>
</div>
@endsection