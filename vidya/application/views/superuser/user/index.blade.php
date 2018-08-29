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
	</div>

	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="{{base_url("superuser")}}"><i class="icon-home2 position-left"></i> Beranda</a></li>
			<li class="active">{{$head_text}}</li>
		</ul>
	</div>
</div>
@endsection

@section("content")
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-flat panel-body">
			<form id="form-bulkaction" method="post" action="{{base_url('superuser/user/bulkaction')}}">
				<div class="row">
					<div class="col-sm-1">
						<div class="checkbox">
							<label>
								<input type="checkbox" class="control-primary" id="checkbox-all">
								All
							</label>
						</div>
					</div>
					<div class="col-md-2">
						<select class="form-control" name="action" required="">
							<option value="">- Pilih Aksi</option>
							<option value="active">Aktifkan</option>
							<option value="suspend">Blokir</option>
							<option value="delete">Hapus data</option>
						</select>
					</div>
					<div class="col-md-2">
						<button type="submit" class="btn bg-purple btn-xs">
							<i class="icon-check position-left"></i> Action
						</button>
					</div>
					<div class="col-md-7 text-right pull-right">
						
						

						<a href="{{base_url("contents/template_pegawai_import.xlsx")}}" class="btn bg-grey btn-labeled heading-btn legitRipple" >
							<b><i class="  icon-download"></i></b>Template
						</a>
						<a href="{{base_url("contents/template_pegawai_import.xlsx")}}" class="btn bg-primary btn-labeled heading-btn legitRipple" >
							<b><i class="icon-shield2"></i></b> Backup
						</a>
						<button type="button" class="btn bg-success btn-labeled heading-btn legitRipple" title="Import data pengguna dari file excel"
						data-toggle="modal" data-target="#modal_import_user"
						>
							<b><i class="  icon-upload"></i></b> Import
						</button>
						<a href="{{base_url("superuser/user/create")}}" class="btn bg-pink btn-labeled heading-btn legitRipple" >
							<b><i class=" icon-plus3"></i></b> Buat Baru
						</a>
					</div>
				</div>
			</form>
		</div>
		<div class="panel panel-flat">

			<table class="table datatable-basic">
				<thead >
					<tr class="bg-slate-800">
						<th><i class="icon-arrow-down12"></i></th>
						<th width="250">Pengguna</th>
						<th width="200">Info</th>
						<th width="200">Log Akhir</th>
						<th width="100">Status</th>
						<th class="text-center" width="100">
							<i class=" icon-cog position-left"></i>
							Aksi
						</th>
					</tr>
				</thead>
				<tbody>
					@foreach($table as $result)
						<tr id="mydatatable-row-{{$result->id}}">
							<td>
								<div class="checkbox">
									<label>
										<input type="checkbox" form="form-bulkaction" class="control-primary" name="data[]" value="{{$result->id}}" >
									</label>
								</div>
							</td>
							<td>
								<div class="media-left media-middle">
									<a href="{{base_url('superuser/user/update/'.$result->id)}}">
										<img src="{{$result->img_src->md}}" class="img-circle img-xs" alt="">
									</a>
								</div>

								<div class="media-body">
									<a href="{{base_url('superuser/user/update/'.$result->id)}}" title="{{$result->title}}" 
										class="display-inline-block text-semibold letter-icon-title text-readmore">
										{{$result->name}}
									</a>
									<div class="text-muted text-size-small text-readmore">
										{{read_more($result->email)}}
									</div>
								</div>
							</td>
							<td>
								<div class="media-body">
									<span class="text-info text-semibold text-readmore" title="Username Pengguna">
										<i class="text-muted text-xs  icon-user position-left"></i>
										{{$result->username}}
									</span>
									<div class="gap-xs"></div>
									<span class="text-info text-semibold text-readmore" title="Telepon Pengguna">
										<i class="text-muted text-xs   icon-phone2 position-left"></i>
										{{$result->phone}}
									</span>
								</div>
							</td>
							<td>
								<i class="text-warning  icon-primitive-dot text-xs position-left"></i>
								{{tgl_indo($result->updated_at)}}
							</td>
							<td>
								<div class="checkbox checkbox-switch" title="Aktif atau Blokir">
									<label>
										<input onchange="changeStatus(this)" class="switch-status switch" data-id="{{$result->id}}" type="checkbox" data-off-text='<i class=" icon-pencil5 text-grey-300"></i>' data-on-text='<i class=" icon-earth"></i>' data-on-color="success" data-off-color="default" data-size="mini" {{match($result->status,'active','checked')}}>
									</label>
								</div>
							</td>
							<td class="text-center">
								<ul class="icons-list">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown">
											<i class="icon-menu9"></i>
										</a>
										<ul class="dropdown-menu dropdown-menu-right">
											<li><a href="{{base_url('superuser/user/update/'.$result->id)}}" title="Ubah Data">
												<i class=" icon-pencil7"></i> Ubah data</a>
											</li>
											<li>
												<a data-url="{{base_url('superuser/user/remove/'.$result->id)}}" 
													href="javascript:void(0)" class="delete-url" title="Hapus Data">
													<i class=" icon-trash"></i> Hapus data
												</a>
											</li>
														
										</ul>
									</li>
								</ul>
							</td>
						</tr>

					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection


@section("footer")
<div id="modal_import_user" class="modal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header bg-success">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title">
					<i class="  icon-upload position-left text-white"></i> Import data pengguna
				</h5>
			</div>

			<div class="modal-body">
				<form id="form_import_pegawai" method="post" action="{{base_url('superuser/user/import')}}" enctype="multipart/form-data">
					<div class="form-group">
						<label><span class="text-danger">*</span> File import berupa file excel :</label>
						<div class="media no-margin-top">
							<div class="media-body">
								<div class="uploader">
									<input type="file" class="file-styled uploader-preview-img" data-src=".upload-img-1" data-text="#upload-text-1" name="excel" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required="">
									<span class="filename" id="upload-text-1" style="user-select: none;">No file selected</span>
									<span class="action btn bg-pink-400 legitRipple" style="user-select: none;">Browse</span>
								</div>
								<span class="help-block no-margin text-sm">
									Format : xlx, xlsx
								</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label><span class="text-danger">*</span> Pilih langkah import :</label>
						<div class="checkbox">
							<label >
								<input type="radio" name="option" value="1" class="styled " required="" >
								<b class="text-danger">Hapus Semua</b> , lalu import
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="radio" name="option" value="2" class="styled" 
								 required="">
								Import data yang belum ada saja
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="radio" name="option" value="3" class="styled" 
								 required="">
								Import semua dan <b class="text-danger">ubah data</b> yang sudah ada
							</label>
						</div>
					</div>
				</form>
				<h6 class="text-semibold text-warning">Peringatan</h6>
				<p>Backup terlebih dahulu keseluruhan data pengguna untuk meminimalisir keadaan yang tidak di inginkan</p>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
				<button type="submit" form="form_import_pegawai" class="btn btn-primary">Mulai Import</button>
			</div>
		</div>
	</div>
</div>
@endsection


@section('scripts')
	@include("pieces.js.datatable")
@endsection