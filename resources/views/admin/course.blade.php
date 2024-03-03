@extends('layouts.app')

@section('content')
<style>
    .table {
        border: 1px solid #ccc;
        border-collapse: collapse;
    }
    .table th, .table td {
        border: 1px solid #ccc;
    }
    .table th, .table td {
        padding: 0.5rem;
    }
    .draggable {
        cursor: move;
        user-select: none;
    }
    .placeholder {
        background-color: #edf2f7;
        border: 2px dashed #cbd5e0;
    }
    .clone-list {
        border-top: 1px solid #ccc;
    }
    .clone-table {
        border-collapse: collapse;
        border: none;
    }
    .clone-table th, .clone-table td {
        border: 1px solid #ccc;
        border-top: none;
        padding: 0.5rem;
    }
    .dragging {
        background: #fff;
        border-top: 1px solid #ccc;
        z-index: 999;
    }
    </style>
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            @if(session()->has('moduledelete'))
            <div class="alert alert-success">
                {{ session()->get('moduledelete') }}
            </div>
            @endif
        <div class="panel-heading"><h4>{{ $course->title ?? 'Nov spletni tečaj' }}</h4>
            <span style="position:absolute; width:32px; height: 3px; background-color:#f41256;"></span>
            <br>
        </div>
        <div class="panel-body">
        <form action="/dashboard/courses/{{ $course->id }}" id="update-course" enctype="multipart/form-data" method="POST">
            @csrf 
            <div class="form-row w-100">
                <div class="form-group col-md-20">
                    <label for="InputImeTecaja">Ime tečaja:</label>
                    <input type="text" class="form-control" id="InputImeTecaja" name="imetecaja" value="{{ $course->title }}">
                </div>
                <div class="form-group col-md-2">
                    <label for="InputBarva">Barva tečaja:</label>
                <select name="barva" id="InputBarva" class="form-control">
                        @if($course->color == 'red')
                        <option value="red" selected>Rdeča</option>
                        <option value="green">Zelena</option>
                        @elseif($course->color == 'green')
                        <option value="red">Rdeča</option>
                        <option value="green">Zelena</option>
                        @else
                        <option selected>Izberite barvo tečaja</option>
                        <option value="red">Rdeča</option>
                        <option value="green">Zelena</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group col-md-16">
                    <label for="InputLinkTecaja">Link tečaja:</label>
                    <input type="text" class="form-control" id="InputLinkTecaja" name="linktecaja" value="{{ $course->link }}">
                </div>
                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="InputOpisTecaja">Opis Tečaja:</label>
                        <div id="InputOpisTecaja" class="div-textarea" contenteditable="true">{!! $course->description !!}</div>
                        <input id="hidden-opis-tecaja" type="hidden" name="opistecaja" value='{!! $course->description !!}'>
                    </div>
                </div>
                <script>
                    document.querySelector('#update-course').addEventListener('DOMSubtreeModified', function() {
                        document.querySelector('#hidden-opis-tecaja').value = document.querySelector('#InputOpisTecaja').innerHTML;
                        console.log('OK');
                    });
                </script>
                <div class="form-row">
                    <div class="form-group col-5"> 
                        <label for="InputSlikica">Naslovna slikica tečaja:</label><br>
                    <img src="{{ asset('/images/'.$course->thumbnail) }}" style="margin-bottom: 6px;" width="125" height="125" alt="Trenutna naslovna slikica tečaja" title="Trenutna slikica tečaja">
                    <br>
                        <input type="file" class="form-control" id="InputSlikica" name="slikica">
                    </div>
                </div>
            <button class="btn btn-primary" type="submit">Shrani spremembe</button>
            <br>
            @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
            @endif
            <br>
        </form>
        <h5>Moduli tečaja</h5>
        <span style="position:absolute; width:32px; height: 3px; background-color:#f41256;"></span>
        <br>
    <form action="/dashboard/courses/{{ $course->id }}/modules" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Dodaj modul</button> 
                </div>
            </div>
        </form>
        <table id="table" class="table">
            <thead>
                <tr>
                    <th scope="col" data-type="number">#</th>
                    <th scope="col">Ime modula</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($modules as $module)
            <tr draggable="true" data-module="{{ $module->id }}">
                <th scope="row">{{ $module->order }}</th>
                <td><a href="/dashboard/courses/{{ $course->id }}/modules/{{ $module->id }}">{{ $module->title }}</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>

    <form action="/dashboard/courses/{{ $course->id }}" method="POST">
    <input type="hidden" name="_method" value="DELETE">
    @csrf
<button type="submit" class="btn btn-primary">Izbriši spletni tečaj</button>
</form>
        </div>
        </div>
</div>
</div>
@endsection 