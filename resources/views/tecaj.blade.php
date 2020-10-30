@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4">
        <h5 style="text-transform: uppercase;"><b>{{ $course->title }}</b></h5>
            <span style="position:absolute; width:32px; height: 3px; background-color:#f41256;"></span>
            <img src="{{ secure_asset('/images/'.$course->description_thumbnail) }}" alt="" height="400">
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

    @if($loop->index == 0)
<div id="collapse{{ $loop->index }}" class="collapse show" aria-labelledby="heading{{ $loop->index }}" data-parent="#accordionExample">
    @else 
    <div id="collapse{{ $loop->index }}" class="collapse" aria-labelledby="heading{{ $loop->index }}" data-parent="#accordionExample">  
    @endif 
      <div class="card-body">
        <div class="row">
            <div class="col-sm-3 col-md-5">
            <img src="{{ secure_asset('/images/'.$module->thumbnail) }}" alt="{{ $module->title }}">
            </div>
            <div class="col-sm-7 col-md-7">
                <div class="panel panel-danger" style="border:1.1px solid #f41256;border-radius:5px;height:100%;">
                    <div class="panel-body">
                        <ul style="padding-left: 5px;">
                            @foreach(DB::table('modulecontent')->where('module_id', $module->id)->get() as $modulecontent)
                        <a class="course-module-item" data-content-type="{{ $modulecontent->type }}" data-content-id="{{ $modulecontent->id }}" data-state="@if($loop->index == 0) {{ 'true' }} @else {{ 'false' }} @endif" style="text-transform: uppercase;"><i class="fa {{ $ikone[$modulecontent->type] ?? '' }}" style="color:#f41256; font-size:24px; padding-right:5px;"></i> {{ $modulecontent->title }}</a> <br>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <video-content></video-content>
            <audio-content></audio-content>
            <ebook-content></ebook-content>
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

