@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
            <h4><a href="/dashboard/courses/{{ $course->id }}">{{ $course->title }}</a> > <a href="/dashboard/courses/{{ $course->id }}/modules/{{ $module->id }}">{{ $module->title }}</a> > {{ $moduleContent->title }}</h4>
            <span style="position: absolute; width: 32px; height: 3px; background-color: rgb(244, 18, 86);"></span>
            <br>
            </div>
            <div class="panel-body">
            <form action="/dashboard/courses/{{ $course->id }}/modules/{{ $module->id }}/contents/{{ $moduleContent->id }}" method="POST">
                @csrf 
                <div class="form-row">
                    <div class="form-group col-md-16">
                        <label for="InputImeVsebine">Ime vsebine modula:</label>
                    <input class="form-control" type="text" name="imevsebine" id="InputImeVsebine" value="{{ $moduleContent->title }}">
                    </div>
                    <div class="form-group">
                        <label for="InputTipVsebine">Tip vsebine modula:</label>
                    <select class="form-control" name="tipvsebine" id="InputTipVsebine" value="{{ $moduleContent->type ?? '' }}">
                            <option value="video">Video</option>
                            <option value="meditacija">Meditacija</option>
                            <option value="eknjiga">E-knjižica</option>
                        </select>
                    </div>
                </div>
                <div id="vsebina" class="form-row">
                    <div class="col-md-12">
                        <label for="InputPovezavaVideo">Povezava do videa:</label>
                    <input class="form-control" type="text" name="videopovezava" id="InputPovezavaVideo" value="{{ $moduleContent->content ?? '' }}">
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <button type="submit" class="btn btn-primary">Shrani spremembe</button>
                </div>
            </form>
            @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
            @endif
            <br>
        <form action="/dashboard/courses/{{ $course->id }}/modules/{{ $module->id }}/contents/{{ $moduleContent->id }}">
            <input type="hidden" name="_method" value="DELETE">
            @csrf
            <div class="form-row">
                <button type="submit" class="btn btn-primary">Izbriši vsebino modula</button>
            </div>
        </form>
            <script>
                var tipVsebine = document.querySelector('#InputTipVsebine');
                var vsebina = document.querySelector('#vsebina');

                tipVsebine.addEventListener('change', function() {

                    if (this.value == 'video') {

                    }
                    else if(this.value == 'meditacija') {

                    }
                    else if(this.value == 'eknjiga') {

                    }
                });
            </script>
            </div>
        </div>
    </div>
</div>
@endsection