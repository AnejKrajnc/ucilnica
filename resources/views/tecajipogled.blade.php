@extends('layouts.app')

@section('content')
    <section class="jumbotron text-center">
      <div class="container">
        <h1>Album example</h1>
        <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely.</p>
        <p>
          <a href="#" class="btn btn-primary my-2">Main call to action</a>
          <a href="#" class="btn btn-secondary my-2">Secondary action</a>
        </p>
      </div>
    </section>
  
    <div class="album py-5 bg-light">
      <div class="container">
  
        <div class="row justify-content-center">
          @if (!empty($courses))
          @foreach ($courses as $course)
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
              <a href="/tecaji/{{ $course->link }}"><img class="bd-placeholder-img card-img-top" src="{{ asset('/images/'. $course->thumbnail ?? '') }}"></a>
              <a href="/tecaji/{{ $course->link }}" style="text-decoration: none !important;"><div class="card-body" style="background-color: #f41256;">
              <h5 class="card-heading" style="color: #fff; text-transform: uppercase; font-size:1rem; font-weight: bold;">{{ $course->title }}</h5>
              <p class="card-text" style="color: #fff;">{{ ' ' }}</p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                   <button type="button" class="btn btn-sm btn-outline-secondary" style="background-color: #fff; border: none; color: #f41256;">spletni tečaj</button>
                  </div>
                  <small style="color: #fff;">Tvoj napredek: </small>
                  <div class="progress" style="width: 125px; background-color: rgba(238, 238, 238, 0.88);">
                  <div class="progress-bar" role="progressbar" style="width: {{ $course->progress ?? '' }}; background-color: #fff;" aria-valuenow="{{ $course->progress ?? '' }}" aria-valuemin="0" aria-valuemax="100"><small style="color: #f41256;">{{ $course->progress }}%</small></div>
                  </div>
                </div>
              </div></a>
            </div>
          </div>
          @endforeach
          @else 
          <p>Trenutno nimaš na voljo nobenega spletnega tečaja <a href="/nakup"><b>Nakupi ga tukaj!</b></a></p>
          @endif
        </div>
      </div>
    </div>
@endsection