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
			<li><a href="{{base_url("superuser/tradingalert")}}">Trading Alert</a></li>
			<li class="active">Buat Baru</li>
		</ul>
	</div>
</div>
@endsection

@section('content')
<form class="form-validate form-aksa-submit" action="{{$url_action}}" data-ckeditor data-type="redirect" data-socket="tradingalert" method="POST" method="post" enctype="multipart/form-data">
@if($type=="update")
<input type="hidden" name="id" value="{{$table->id}}">
@endif
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-flat">
			<div class="panel-body">
				<div class="form-group">
					<label><b class="text-danger position-left">*</b>Symbol Perusahaan : </label>
					<input type="text" name="symbol" value="{{@$table->symbol}}" class="form-control" placeholder="Ketikan Symbol Perusahaan di sini ..." required="">
				</div>
				<div class="form-group">
					<label><b class="text-danger position-left">*</b>Ukuran Power : </label>
					<input type="number" name="power" value="{{@$table->power}}" class="form-control" placeholder="Beri ukuran 'power'" required="">
				</div>
				<div class="form-group">
					<label><b class="text-danger position-left">*</b>Pilih Tanggal dan Waktu : </label>
					<input type="text" name="datetime" class="form-control daterange-single-time" value="{{@$table->datetime}}" required=""> 
				</div>
				<div class="form-group">
					<label><i class=" icon-image5 position-left text-primary"></i> Gambar Grafik :</label>
					<div class="media no-margin-top">
						<div class="media-left">
							<a href="{{giveImageIfNull(@$table->img_src->xs,'image-lg')}}" class="fancybox upload-img-1" data-popup="lightbox">
								<img class="upload-img-1" src="{{giveImageIfNull(@$table->img_src->xs,'image-xs')}}" style="width: 58px; height: 58px;object-fit: cover; border-radius: 2px;" alt="">
							</a>
						</div>

						<div class="media-body">
							<div class="uploader">
									<input type="file" class="file-styled uploader-preview-img" data-src=".upload-img-1" data-text="#upload-text-1" name="image">
									<span class="filename" id="upload-text-1" style="user-select: none;">No file selected</span>
									<span class="action btn bg-pink-400 legitRipple" style="user-select: none;">Browse</span>
								</div>
							<span class="help-block no-margin text-sm">
								Format : png, jpg. Maks 5Mb
								@if($type=="update")
									, Jangan ubah jika tidak ada perubahan
								@endif
							</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label><b class="text-danger position-left">*</b>Isi Remarks : </label>
					<textarea class="form-control" name="remark" required="">{!! @$table->remark !!}</textarea>
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