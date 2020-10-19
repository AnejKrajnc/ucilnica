@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            @if (session()->has('alert-content'))
                <div class="alert alert-success">
                    {{ session()->get('alert-content') }}
                </div>
            @endif
        <div class="panel-heading">
            <h4><a href="/dashboard/courses/{{ $course->id }}">{{ $course->title }}</a> > {{ $module->title }}</h4>
            <span style="position: absolute; width: 32px; height: 3px; background-color: rgb(244, 18, 86);"></span>
            <br>
        </div>
        <div class="panel-body">
            <form action="/dashboard/courses/{{ $course->id }}/modules/{{ $module->id }}" method="POST">
            @csrf 
            <div class="form-row">
                <div class="form-group col-md-16">
                    <label for="InputImeModula">Ime modula:</label>
                <input type="text" class="form-control" id="InputImeModula" value="{{ $module->title ?? '' }}" name="imemodula">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="InputOpisModula">Kratek opis modula:</label>
                    <textarea class="form-control" id="InputOpisModula" name="opismodula">{{ $module->description ?? '' }}</textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Shrani spremembe</button>
            </form>
            <br>
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            <br>
            <h4>Vsebina modula</h4>
            <span style="position: absolute; width: 32px; height: 3px; background-color: rgb(244, 18, 86);"></span>
            <br>
            <form action="/dashboard/courses/{{ $course->id }}/modules/{{ $module->id }}/contents" method="POST">
                @csrf 
                <div class="form-row">
                <button type="submit" class="btn btn-primary">Dodaj novo vsebino</button>
                </div>
            </form>
            <br>
            <table class="table">
                <thead>
                    <th scope="col">#</th>
                    <th scope="col">Ime vsebine</th>
                    <th scope="col">Tip vsebine</th>
                </thead>
                <tbody>
                    @foreach($modulecontents as $content)
                    <tr>
                        <th scope="row">1</th>
                    <td><a href="/dashboard/courses/{{ $course->id }}/modules/{{ $module->id }}/contents/{{ $content->id }}">{{ $content->title }}</a></td>
                    <td>{{ $content->type }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        <form action="/dashboard/courses/{{ $course->id }}/modules/{{ $module->id }}" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            @csrf 
            <div class="form-row">
                <button class="btn btn-primary">Izbriši modul</button>
            </div>
        </form>
        </div>
        </div>
    </div>
</div>
@endsection