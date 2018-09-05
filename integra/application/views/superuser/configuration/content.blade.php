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
			<li><a href="{{base_url("superuser/configuration")}}">Konfigurasi</a></li>
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
				<fieldset>
					<legend class="text-semibold">
						<i class="icon-file-text2 position-left"></i>
						Informasi Umum Website
						<a class="control-arrow" data-toggle="collapse" data-target="#demo1">
							<i class="icon-circle-down2"></i>
						</a>
					</legend>

					<div class="collapse in" id="demo1">
						<div class="form-group">
							<label><b class="text-danger position-left">*</b>Nama Website : </label>
							<input type="text" name="name" value="{{@$table->name}}" class="form-control" placeholder="Ketikan Nama Website" required="">
						</div>
						<div class="form-group">
							<label><b class="text-danger position-left">*</b>Nama Perusahaan : </label>
							<input type="text" name="company_name" value="{{@$table->company_name}}" class="form-control" placeholder="Ketikan Nama Perusahaan" required="">
						</div>
					</div>
				</fieldset>
				
				<div class="form-group">
					<label><b class="text-danger position-left">*</b>Nama Perusahaan : </label>
					<input type="text" name="company_name" value="{{@$table->company_name}}" class="form-control" placeholder="Ketikan Nama Perusahaan" required="">
				</div>
				<div class="form-group">
					<label><b class="text-danger position-left">*</b><i>Default</i> Keywords Website : </label>
					<input type="text" name="keywords" value="{{@$table->keywords}}" class="form-control" placeholder="Ketikan keywords website" required="">
					<div class="help-block">
						Contoh penulisan : <i>Jual Beli Barang, Jual Barang Elektronik, Jual Barang A</i>
					</div>
				</div>
				<div class="form-group">
					<label><b class="text-danger position-left">*</b><i>Default</i> Deskripsi Website : </label>
					<textarea class="form-control" name="description" rows="5" placeholder="Deskripsi Website anda">{{@$table->description}}</textarea>
				</div>
				<div class="form-group">
					<label>Google Tracking ID : </label>
					<input type="text" name="google_tracking_id" value="{{@$table->google_tracking_id}}" class="form-control" placeholder="Google Tracking ID">
					<div class="help-block">
						Google Tracking ID untuk google analytic , pelajari selengkapnya 
						<a href="https://marketingplatform.google.com/about/analytics/" target="_blank">disini</a>
					</div>
				</div>
				<div class="form-group">
					<label>Facebook Pixel Code: </label>
					<textarea rows="5" class="form-control" placeholder="Facebook Pixel Code Here" name="fb_pixel">{!! @$table->fb_pixel !!}</textarea>
					<div class="help-block">
						Facebook Pixel untuk analisa perkembangan web anda berdasarkan pengunjung , pelajari selengkapnya 
						<a href="https://web.facebook.com/business/help/952192354843755?_rdc=1&_rdr" target="_blank">disini</a>
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