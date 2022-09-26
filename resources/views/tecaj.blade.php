@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4">
        <h5 style="text-transform: uppercase;"><b>{{ $course->title }}</b></h5>
            <span style="position:absolute; width:32px; height: 3px; background-color:rgb(93, 206, 45);"></span>
            <img src="{{ secure_asset($course->description_thumbnail) }}" alt="" height="400">
        </div>
        <div class="col-sm-6">
            <br>
            <br>
            <br>
            {!! $course->description !!}
        </div>
    </div>
    <div class="row">
    <div class="col-11">
    <div class="accordion" id="accordionExample">
      
  <div class="card">
      @foreach($modules as $module)
    <div class="card-header" id="heading{{ $loop->index }}">
      <h5 class="mb-0">
      <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{ $loop->index }}" aria-expanded="false" aria-controls="collapse{{ $loop->index }}">
            {{ $module->title }}
        </button>
      </h5>
    </div>

    @if(($loop->index == 0 && !isset($vsebina)))
<div id="collapse{{ $loop->index }}" class="collapse show" aria-labelledby="heading{{ $loop->index }}" data-parent="#accordionExample">
    @elseif(isset($vsebina) && (DB::table('modulecontent')->where('content_link', $vsebina)->first()->module_id == $module->id))
<div id="collapse{{ $loop->index }}" class="collapse show" aria-labelledby="heading{{ $loop->index }}" data-parent="#accordionExample">
    @else 
    <div id="collapse{{ $loop->index }}" class="collapse" aria-labelledby="heading{{ $loop->index }}" data-parent="#accordionExample">  
    @endif 
      <div class="card-body">
        <div class="row">
            <div class="col-sm-3 col-md-5">
            <img src="{{ secure_asset($module->thumbnail) }}" alt="{{ $module->title }}" width="242" height="200">
            </div>
            <div class="col-sm-10 col-md-7 mt-2">
                <div class="panel panel-danger" style="border:1.1px solid rgb(93, 206, 45);border-radius:5px;height:100%;">
                    <div class="panel-body">
                        <ul style="padding-left: 5px;">
                            @foreach(DB::table('modulecontent')->where('module_id', $module->id)->orderByRaw('type DESC')->get() as $modulecontent)
                            @if(isset($vsebina))
                            @if(DB::table('modulecontent')->where('content_link', $vsebina)->first()->id == $modulecontent->id)
                        <a class="course-module-item" data-content-type="{{ $modulecontent->type }}" data-content-id="{{ $modulecontent->id }}" style="text-transform: uppercase; color:rgb(93, 206, 45);"><i class="fa {{ $ikone[$modulecontent->type] ?? '' }}" style="color:rgb(93, 206, 45); font-size:24px; padding-right:5px;"></i> {{ $modulecontent->title }}</a> <br>
                            @endif
                            @else
                        <a class="course-module-item" data-content-type="{{ $modulecontent->type }}" data-content-id="{{ $modulecontent->id }}" style="text-transform: uppercase;"><i class="fa {{ $ikone[$modulecontent->type] ?? '' }}" style="color:rgb(93, 206, 45); font-size:24px; padding-right:5px;"></i> {{ $modulecontent->title }}</a> <br>
                            @endif
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="content-shower">
                @if(isset($vsebina) && (DB::table('modulecontent')->where('content_link', $vsebina)->first()->module_id == $module->id))
                @php
                $zaprikaz = DB::table('modulecontent')->where('content_link', $vsebina)->first();
                @endphp
                @if($zaprikaz->type == 'video')
                <iframe width="560" height="315" 
                src="https://www.youtube.com/embed/{{ $zaprikaz->content ?? '' }}" 
                title="YouTube video player" 
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                </iframe>
                @elseif($zaprikaz->type == 'meditacija')
                <iframe width="380" height="350" scrolling="no" frameborder="no" allow="autoplay" 
                src="https://w.soundcloud.com/player/?url={{ $zaprikaz->content ?? '' }}&color=%235dce2d&auto_play=false&hide_related=false&show_comments=false&show_user=false&show_reposts=false&show_teaser=false&visual=true"
                ></iframe>
                @elseif($zaprikaz->type == 'eknjiga')
                <div class="show-module-content">
                <a class="btn btn-primary" href="/prenos/tecaji/prenos/{{ $zaprikaz->content ?? '' }}" target="_blank">Prenesi e-knjižico!</a>
                </div>
                @endif
                @endif
            </div>
        </div>
      </div>
    </div>
  @endforeach
</div>
    </div>
    </div>
</div>
@endsection

