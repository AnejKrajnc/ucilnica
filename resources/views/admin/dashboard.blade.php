@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Aktivnosti v spletni učilnici</h4></div>
                <div class="panel-body">
                    <h4>Število udeležencev:</h4>
                <h5>{{ DB::table('users')->where('usertype','student')->count() }}</h5>
                </div>
              </div>
        </div>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Tečaji</h4>
                </div>
                <div class="panel-body">
                    <table class="table">
                      <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="text-center">Ime tečaja</th>  
                    <th scope="col">Število udeležencev</th>  
                    </tr>      
                    </thead>
                    <tbody>
                        @foreach (DB::table('course')->get() as $course)
                        <tr>
                        <th scope="row">{{ $course->id }}</th>
                        <td><a href="/dashboard/courses/{{ $course->id }}">{{ $course->title }}</a></td>
                        <td class="text-center">{{ DB::table('course_enrolled')->where('course_id', $course->id)->count() ?? '0' }}</td>
                        </tr>
                        @endforeach
                    </tbody>  
                    </table>
                    <form action="dashboard/courses" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Dodaj nov tečaj</button>
                    </form>
                    <br>
                    <h4>Nakupi spletnih tečajev</h4>
                    <p>Poglej vse nakupe spletnih tečajev - <a href="/dashboard/orders"><b>Nakupi</b></a></p>
                    <h4>Uporabniki</h4>
                    <p>Poglej uporabnike spletne učilnice - <a href="/dashboard/users"><b>Uporabniki</b></a></p>
                    <h4>Kode za popust</h4>
                    <p>Poglej kode za popust spletne učilnice - <a href="/dashboard/cupons"><b>Kode za popuste</b></a></p>
                </div>
            </div>
    </div>
@endsection