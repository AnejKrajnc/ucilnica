@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @foreach ($courses as $course)
        <div class="col-sm-5 col-md-4 text-center">
            <a href="/tecaji/{{ $course->link ?? '' }}" style="text-decoration: none;"><div class="thumbnail">
                <img src="{{ asset('/images/'.$course->thumbnail ?? '') }}" alt="{{ $course->title }}" width="100%" height="auto">
                <div class="caption justify-content-center" style="background-color:#f41256;">
                    <h5 style="color:#fff;">{{ $course->title }}</h5>
                </div>
            </div></a>
        </div>
        @endforeach
    </div>
</div>
@endsection
