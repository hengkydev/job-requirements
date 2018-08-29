@extends('superuser.template')

@section('title')
{{$head_text}}
@endsection

@section('heading')
<div class="page-header page-header-default border-top-lg border-top-primary">
	<div class="page-header-content">
		<div class="page-title">
			<h5>
				<i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{{$head_text}}</span> - {{$body_text}}
				<small class="display-block">{{$body_text}}</small>
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
			<li><a href="{{base_url("superuser/socialmedia")}}">Social Media</a></li>
			<li class="active">Buat Baru</li>
		</ul>
	</div>
</div>
@endsection

@section('content')
<form class="form-validate form-aksa-submit" action="{{$url_action}}" data-ckeditor data-type="redirect" method="POST" method="post" enctype="multipart/form-data">
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-flat">
			<div class="panel-body">
				<div class="form-group">
					<label><b class="text-danger position-left">*</b>Nama Social Media : </label>
					@if($type!="create")
							<input type="hidden" name="id" value="{{$table->id}}">
					@endif
					<input type="text" name="name" value="{{@$table->name}}" class="form-control" placeholder="Ketikan Nama Social Media di sini ..." required="">
				</div>
				<div class="form-group">
					<label><b class="text-danger position-left">*</b>Jenis Sosial Media </label>
					<select class="form-control select2" name="type" required="">
					@foreach($data_type as $result)
						<option value="{{$result}}">{{$result}}</option>
					@endforeach
					</select>
				</div>
				<div class="form-group">
					<label><b class="text-danger position-left">*</b>URL Social Media : </label>
					<input type="text" name="url" value="{{@$table->url}}" class="form-control" placeholder="Ketikan URL Social Media di sini ..." required="">
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