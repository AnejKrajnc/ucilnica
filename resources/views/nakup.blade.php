@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
        <div class="col-md-7">
          <div class="card">
              <div class="card-header">Nakup spletnih tečajev</div>
              <div class="card-body">
                @isset($items)
              <form action="/nakup" method="POST">
                  <h4>1. korak - Podatki o plačniku</h4>
                  @csrf
    <div class="form-row">
        <div class="form-group col-md-7">
            <label for="InputTecaj">Izberite spletni tečaj</label>
            <select id="InputTecaj" class="form-control @error('izdelek') is-invalid @enderror" name="izdelek">
                <option selected disabled>Izberite spletni tečaj</option>
                @foreach($items as $item)
            <option value="{{ $item->id }}">{{ $item->name }} - {{ number_format($item->price, 2, ',', ' ') }} €</option>
                @endforeach
            </select>
            @error('izdelek')
                <div class="alert alert-danger"> {{ $message }} </div>
            @enderror
        </div>
    </div>
    <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputIme">Ime:</label>
      @error('ime')
          <div class="alert alert-danger"> {{ $message }} </div>
      @enderror
      <input type="text" class="form-control @error('ime') is-invalid @enderror" id="inputIme" placeholder="Ime" name="ime">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPriimek">Priimek:</label>
      @error('priimek')
          <div class="alert alert-danger"> {{ $message }} </div>
      @enderror
      <input type="text" class="form-control @error('priimek') is-invalid @enderror" id="inputPriimek" placeholder="Priimek" name="priimek">
    </div>
  </div>
  <div class="form-group">
    <label for="inputNaslov">Naslov:</label>
    @error('naslov')
          <div class="alert alert-danger"> {{ $message }} </div>
      @enderror
    <input type="text" class="form-control @error('naslov') is-invalid @enderror" id="inputNaslov" placeholder="Ulica in hišna številka" name="naslov">
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputKraj">Kraj:</label>
      @error('kraj')
          <div class="alert alert-danger"> {{ $message }} </div>
      @enderror
      <input type="text" class="form-control @error('kraj') is-invalid @enderror" id="inputKraj" placeholder="Kraj" name="kraj">
    </div>
    <div class="form-group col-md-3">
      <label for="inputPostnaStevilka">Poštna številka:</label>
      @error('postal')
          <div class="alert alert-danger"> {{ $message }} </div>
      @enderror
      <input type="text" class="form-control @error('postal') is-invalid @enderror" id="inputPostnaStevilka" placeholder="XXXX" name="postal">
    </div>
  </div>
  <div class="form-row">
      <div class="form-group col-md-5">
          <label for="inputTelefon">Telefon:</label>
          @error('telefon')
          <div class="alert alert-danger"> {{ $message }} </div>
      @enderror
          <input type="tel" class="form-control @error('telefon') is-invalid @enderror" id="inputTelefon" placeholder="000 000 000" name="telefon">
      </div>
      <div class="form-group col-md-7">
          <label for="inputEmail">E-poštni naslov:</label>
          @error('email')
          <div class="alert alert-danger"> {{ $message }} </div>
      @enderror
          <input type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" placeholder="E-poštni naslov" name="email">
      </div> 
  </div>
  <div class="form-row">
    <div class="form-group col-md-4">
          <label for="inputKodaPopust">Koda za popust:</label>
          <input type="text" class="form-control" id="inputKodaPopust" placeholder="Koda za popust" name="cuponcode">
      </div>
  </div>
  <div class="form-row">
  <div class="col-md-5">
  <button type="submit" class="btn btn-primary">Nadaljuj na način plačila</button>
</div>
  </div>
</form>
@endisset
<br>
@isset($step)
@if($step == 2)
<form method="POST">
  @csrf 
    <h4>2. korak - Način plačila</h4>
    <div class="form-row">
        <div class="form-group col-md-4">
            <input type="radio" id="inputPredracun" name="nacin-placila" value="predracun">
            <label for="inputPredracun">Plačilo po predračunu</label>
        </div>
        <div class="form-group col-md-4">
            <input type="radio" id="inputPayPal" name="nacin-placila" value="paypal">
            <label for="inputPayPal">Plačilo preko PayPala</label>
        </div>
        @error('nacin-placila')
            <div class="alert alert-danger"> Izberite način plačila!</div>
        @enderror
    </div>
    <div class="form-row">
    <div class="col-md-5">
        <button type="submit" class="btn btn-primary">Nadaljuj na potrditev nakupa</button>
    </div>
    </div>
</form>
@endif
@endisset
@isset($step)
@if($step == 'paypal')
<div class="paypal">
<paypal-checkout></paypal-checkout>
</div>
@endif
@endisset
@isset($step)
@if($step == 3)
@isset($data && $payment)
    @if($payment == 'paypal')
    <h4>4. Zaključen nakup</h4>
    <p>Uspešno ste opravili vaš nakup!</p>
    <p><b>V nekaj minutah lahko v vašem e-poštnem nabiralniku pričakujete sporočilo s podatki za prijavo.</b></p>
    <i>Sporočilo se lahko tudi nahaja v nezaželeni pošti (junk/scam)</i>
    @endif
@endisset
@endif
@endisset
@isset($napaka)
    <div class="alert alert-danger">
        Pri izvedbi nakupa in plačila je prišlo do napake!
    </div>
@endisset
              </div>
          </div>  
          </div>
</div>
</div>
</div>
@endsection