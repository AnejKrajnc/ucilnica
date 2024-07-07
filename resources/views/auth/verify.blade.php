@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card" style="background-color:rgba(254,254,254, 0.75);">
                <div class="card-header" style="background-color:#5dce2d;color:#fff;font-family:'Shadows Into Light';font-size:21px;">{{ __('Nastavitev osebnega gesla') }}</div>

                <div class="card-body">
                    <form method="POST" action="/potrdi-nastavi-geslo/{{ $registrationToken }}">
                        @csrf

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Geslo:') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Ponovi Geslo:') }}</label>

                            <div class="col-md-6">
                                <input id="confirm-password" type="password" class="form-control @error('password') is-invalid @enderror" name="confirm-password" required autocomplete="current-password">

                                @error('confirm-password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Potrdi nastavitev gesla!') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
