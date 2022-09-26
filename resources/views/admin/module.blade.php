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
            <form action="/dashboard/courses/{{ $course->id }}/modules/{{ $module->id }}" method="POST" enctype="multipart/form-data">
            @csrf 
            <div class="form-row">
                <div class="form-group col-md-16">
                    <label for="InputImeModula">Ime modula:</label>
                <input type="text" class="form-control" id="InputImeModula" value="{{ $module->title ?? '' }}" name="imemodula">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-16">
                    <label for="InputOrder">Razvrstitev:</label>
                <input type="number" class="form-control" id="InputOrder" value="{{ $module->order ?? '' }}" name="order">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="InputOpisModula">Kratek opis modula:</label>
                    <textarea class="form-control" id="InputOpisModula" name="opismodula">{{ $module->description ?? '' }}</textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="InputSlikica">Slikica modula:</label><br>
                    <img id="predogledSlikice" src="{{ asset($module->thumbnail) }}" alt="Trenutna slika modula" width="250" height="250">
                   <input type="file" name="slikica" id="InputSlikica" class="form-control">
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
            <form id="add-modulecontent" action="javascript:void(0);" data-courseid="{{ $course->id }}" data-moduleid="{{ $module->id }}">
                @csrf 
                <div class="form-row">
                <button type="submit" class="btn btn-primary">Dodaj novo vsebino</button>
                </div>
            </form>
            <br>
            <table id="table-modulecontent" class="table">
                <thead>
                    <th scope="col">#</th>
                    <th scope="col">Ime vsebine</th>
                    <th scope="col">Tip vsebine</th>
                </thead>
                <tbody>
                    @foreach($modulecontents as $content)
                    <tr>
                        <th scope="row">{{ $loop->index+1 }}</th>
                    <td><a class="modulecontent-link" data-modulecontentid="{{ $content->id }}" style="cursor: pointer;">{{ $content->title }}</a></td>
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Dodajanje novega tečaja</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Nalagam...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Zapri</button>
        </div>
      </div>
    </div>
  </div>
@endsection