@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card" style="background-color:rgba(254,254,254, 0.75);">
                <div class="card-header" style="background-color:#5dce2d;color:#fff;font-family:'Shadows Into Light';font-size:21px;">{{ __('Nastavitev osebnega gesla') }}</div>

                <div class="card-body">
                    <p>Uporabniški račun uspešno aktiviran z nastavljenim geslom.
                    </p>
                    <a class="btn btn-link" href="{{ route('login') }}">
                                        {{ __('Prijava') }}
                                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection