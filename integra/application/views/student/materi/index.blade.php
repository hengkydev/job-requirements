@extends('student.template')

@section('title')
{{$head_text}}
@endsection

@section('header')
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{{$head_text}}</span> - {{$body_text}}</h4>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{base_url('student')}}"><i class="icon-home2 position-left"></i> Beranda</a></li>
            <li class="active">Beranda</li>
        </ul>
    </div>
</div>
@endsection

@section("content")
<div class="row">
	<div class="col-md-12">
		<div class="row">
			@foreach($table as $result)
			<div class="col-md-6">
				<div class="panel border-left-lg border-left-primary timeline-content">
					<div class="panel-body">
						<div class="row">							
							<div class="col-md-4">
								<div class="thumbnail no-margin">
									<div class="thumb">
										<img src="{{$result->img_src->sm}}" alt="">
										<div class="caption-overflow">
											<span>
												<a href="{{$result->img_src->lg}}" data-popup="lightbox" rel="gallery" class="btn border-white text-white btn-flat btn-icon btn-rounded legitRipple"><i class="icon-plus3"></i></a>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-8">
								<h6 class="no-margin">
									<a href="{{base_url('student/materi/detail'.$result->id)}}" >
										{{$result->name}}
									</a>
								</h6>
								<div class="help-block">
									{{read_more($result->description,100)}}
								</div>
							</div>
						</div>
					</div>

					<div class="panel-footer">
						<a class="heading-elements-toggle"><i class="icon-more"></i></a>
						<div class="heading-elements">
							<span class="heading-text text-semibold text-grey">
								<i class=" icon-calendar22 position-left"></i>
								{{tgl_indo($result->updated_at)}}
							</span>
							<div class="heading-btn pull-right">
								<a href="{{base_url('student/materi/detail/'.$result->id)}}" class="btn border-primary btn-xs text-primary btn-flat legitRipple">
									Detail
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>
@endsection


@section('scripts')
	@include("pieces.js.datatable")
@endsection