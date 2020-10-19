@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Koda za popust</h4>
                <span style="position:absolute; width:32px; height: 3px; background-color:#f41256;"></span>
            </div>
            <br>
            @if(session()->has('delete-alert'))
                <div class="alert alert-success">
                    {{ session()->get('delete-alert') }}
                </div>
            @endif
            <div class="panel-body">
            <form action="/dashboard/cupons/{{ $cupone->id }}" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="InputKodaPopust">Koda za popust:</label>
                    <input type="text" class="form-control" name="kodapopusta" id="InputKodaPopust" value="{{ $cupone->code ?? '' }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="InputPopust">Popust:</label>
                    <input type="number" step="any" class="form-control" name="diskont" id="InputPopust" value="{{ $cupone->discount ?? '' }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-10">
                        <label for="InputVeljaPopust">Popust velja za tečaje:</label>
                        <select class="form-control" name="tecajipopust" id="InputVeljaPopust" multiple>
                            <option value="1">Energetsko partnerstvo</option>
                            <option value="2">Energetsko starševstvo</option>
                            <option value="3">Energetska priprava na zanositev</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <label for="InputExpire">Poteče:</label>
                    <input type="date" class="form-control" name="expires" id="InputExpire" value="{{ $cupone->expires }}">
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <button type="submit" class="btn btn-primary">Shrani spremembe</button>
                </div>
            </form>
            <br>
        <form action="/dashboard/cupons/{{ $cupone->id }}" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            @csrf 
            <button type="submit" class="btn btn-primary">Izbriši kupon</button>
        </form>
            </div>
        </div> 
    </div>
</div>
@endsection