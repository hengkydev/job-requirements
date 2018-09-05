@extends('superuser.template')

@section('title')
{{$text_content}}
@endsection

@section('heading')
<div class="page-header page-header-default border-top-lg border-top-primary">
	<div class="page-header-content">
		<div class="page-title">
			<h5>
				<i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Video</span> - Buat Baru
				<small class="display-block">Membuat artikel baru</small>
			</h5>
		<a class="heading-elements-toggle"><i class="icon-more"></i></a></div>

		<div class="heading-elements">
			<a class="btn bg-slate btn-xs btn-labeled heading-btn legitRipple" href="javascript:void(0);" onclick="window.history.back()" >
				<b><i class=" icon-arrow-left12"></i></b> Kembali
			</a>
		</div>
	</div>

	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="{{base_url("superuser")}}"><i class="icon-home2 position-left"></i> Beranda</a></li>
			<li><a href="{{base_url("superuser/post")}}">Video</a></li>
			<li class="active">Buat Baru</li>
		</ul>
	</div>
</div>
@endsection

@section('content')
<form class="form-validate form-aksa-submit" action="{{$url_action}}" data-ckeditor data-type="redirect" method="POST" method="post" enctype="multipart/form-data">
		
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-flat panel-body">
			<div class="row">
				<div class="col-md-5">
					<div class="form-group">
						<input type="hidden" name="id" value="{{@$table->id}}" required="">
						<label><span class="position-left text-danger text-semibold">*</span>Nama video :</label>
						<input type="text" class="form-control" name="name" value="{{@$table->name}}" placeholder="Ketik nama video di sini ..." required="">
					</div>
					<div class="form-group">
						<label class="display-block">
							<span class="position-left text-danger text-semibold">*</span>Jenis Video :
						</label>
						<label class="radio-inline">
							<input type="radio" name="type" value="file" class="styled aksa-show-hide" 
							data-show=".container-select-video" data-hide=".container-select-youtube" 
							{{match(@$table->type,"file",'checked')}} required="" >
							<span class="label label-primary label-icon">
								<i class=" icon-upload position-left"></i>
								Video File
							</span>
						</label>

						<label class="radio-inline">
							<input type="radio" name="type" value="youtube" class="styled aksa-show-hide" 
							data-show=".container-select-youtube" data-hide=".container-select-video"
							{!! match(@$table->type,"youtube",'checked') !!}
							 required="">
							<span class="label label-danger label-icon">
								<i class=" icon-youtube position-left"></i>
								Youtube URL
							</span>
						</label>
					</div>
					<div class="form-group container-select-video" {!! match(@$table->type,'youtube','style="display:none;"') !!}>
						<label class="display-block">
							<span class="position-left text-danger text-semibold">*</span>Pilih File Video :
						</label>
						<div class="gap-xs"></div>
						<label class="btn bg-pink btn-labeled btn-rounded legitRipple position-left">
							<b>
								<i class="icon-upload"></i>
							</b>
							<input type="file" name="value" style="display: none;" class="aksa-file-upload-preview" 
							data-caption="#caption-file-video" 
							data-source="#source-file-video"
							name="value" accept="video/*">
							Browse
						</label>
						<span class="text-grey" id="caption-file-video">
							@if($type=="update" && @$table->type=="file")
								{{$table->value}}
							@else
								Tidak ada file yang di pilih	
							@endif
						</span>
						<div class="help-block">
							Format file video yag di perbolehkan 
							<span class="text-primary text-semibold">.mkv</span>,
							 <span class="text-primary text-semibold">.mp4</span>,
							 <span class="text-primary text-semibold">.avi</span>,
							 <span class="text-primary text-semibold">.mov</span>
							 <div class="gap-xs"></div>
							 @if($type=="update" && @$table->type=="file")
							 	Jangan ubah file jika tidak ada perubahan
							 @endif
						</div>
					</div>
					@if($type=="create")
					<div class="form-group container-select-youtube" style="display: none;" >
					@else
					<div class="form-group container-select-youtube" {!! match(@$table->type,'file','style="display:none;"') !!} >
					@endif
						<label>
							<span class="position-left text-danger text-semibold">*</span> Masukan URL Youtube :
						</label>
						<textarea class="form-control youtube-preview-embed" name="value" data-target="#youtube-embed" placeholder="(eg) : https://www.youtube.com/watch?v=_qU2MXeAz1E">{{match(@$table->type,'youtube',@$table->value)}}</textarea>
					</div>
				</div>
				<div class="col-md-7">
					@if($type=="create")
						<div class="container-select-video">
					@else
						<div class="container-select-video" {!! match(@$table->type,'youtube','style="display:none;"') !!} >
					@endif
						<video style="width: 100%;" controls>
						 @if($table->type=="file")
						 	<source src="{{$table->video_dir}}" id="source-file-video">
						 @else
						  	<source src="" id="source-file-video">
						  @endif
						</video>
					</div>
					@if($type=="create")
						<div class="container-select-youtube" style="display: none;">
						<iframe id="youtube-embed" style="width: 100%;height: 300px;" frameborder="0" allowfullscreen></iframe>
					@else
						@if($table->type=="file")
							<div class="container-select-youtube" style="display: none;">
							<iframe id="youtube-embed" style="width: 100%;height: 300px;" frameborder="0" allowfullscreen></iframe>
						@else
							<div class="container-select-youtube">
							<iframe id="youtube-embed" src="{{$table->video_dir}}" style="width: 100%;height: 300px;" frameborder="0" allowfullscreen></iframe>
						@endif
						
					@endif
						
					</div>
				</div>
				
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<textarea id="editor-full" class="form-control" name="description">{!! @$table->description !!}</textarea>
	</div>
	<div class="col-md-4">
		<div class="panel panel-flat">
			<div class="panel-body">
				<div class="form-group">
					<label><i class=" icon-exclamation position-left text-warning"></i>Status Video : </label>
					<div class="checkbox checkbox-switch">
						<label>
							@if($type=="create")
							<input type="checkbox" class="switch" name="status" data-on-text="Publish" data-off-text="Draft" name="status" checked="checked">
							@else
							<input type="checkbox" class="switch" name="status" data-on-text="Publish" data-off-text="Draft" name="status" {{match($table->status,"publish","checked")}}>
							@endif
						</label>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="gap-sm"></div>
<div class="row">
	<div class="col-md-12">

		<button type="submit" class="btn bg-pink btn-labeled heading-btn legitRipple">
			<b><i class=" icon-arrow-right13"></i></b> Terapkan
		</button>
		<a href="javascript:void();" onclick="history.back();" class="btn bg-grey heading-btn legitRipple">
			Batalkan
		</a>
	</div>
</div>

</form>
@endsection

@section("scripts")
	@include("pieces.js.form")
@endsection