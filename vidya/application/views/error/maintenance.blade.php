@extends('error.template')

@section('title')
Sorry Our Website Has Maintenance 
@stop

@section('slider')
<div class="gap"></div>
@stop

@section('content')
    <div class="col-md-12 clearfix">
        <div class="box">
            <div class="header">
               Website Under Maintenance
            </div>
            <div class="content">
                <div class="col-md-4 margin-center">
                <img src="{{$config->logofile}}" class="img-responsive">
                </div>
                <h1 class="text-center" style="font-size:100px;">
                    503
                </h1>
                 <div class="gap"></div>
                <div class="col-md-8 margin-center">
                    <article class="text-muted text-left">
                        {!! $config->error !!}
                    </article>
                </div>
                <div class="gap"></div>
            </div>            
            <div class="footer">
            <span class="text-center nomargin text-muted">
                Copyright - <a href="{{base_url()}}">{{$config->name}}</a> | Created By <a href="http://aksamedia.com">Aksamedia</a>
            </span>
            </div>
        </div>
    </div>
@stop