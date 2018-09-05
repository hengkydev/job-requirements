@extends('superuser.template')

@section('title')
{{$text_content}}
@endsection

@section('heading')
<div class="page-header page-header-default border-top-lg border-top-primary">
	<div class="page-header-content">
		<div class="page-title">
			<h5>
				<i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Video</span> - Daftar Video
				<small class="display-block">Daftar video anda</small>
			</h5>
		<a class="heading-elements-toggle"><i class="icon-more"></i></a></div>
	</div>

	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="{{base_url("superuser")}}"><i class="icon-home2 position-left"></i> Beranda</a></li>
			<li class="active">Video</li>
		</ul>
	</div>
</div>
@endsection

@section("content")
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-flat panel-body">
			<form id="form-bulkaction" method="post" action="{{base_url('superuser/video/bulkaction')}}">
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
							<option value="publish">Publish</option>
							<option value="draft">Draft</option>
							<option value="delete">Hapus data</option>
						</select>
					</div>
					<div class="col-md-2">
						<button type="submit" class="btn bg-purple btn-xs">
							<i class="icon-check position-left"></i> Action
						</button>
					</div>
					<div class="col-md-2 text-right pull-right">
						<a href="{{base_url("superuser/video/create")}}" class="btn bg-pink btn-labeled heading-btn legitRipple" >
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
						<th width="300">Video</th>
						<th>Tipe</th>
						<th width="200">Tanggal</th>
						<th>Status</th>
						<th class="text-center">Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($video as $result)
						<tr>
							<td>
								<div class="checkbox">
									<label>
										<input type="checkbox" form="form-bulkaction" class="control-primary" name="data[]" value="{{$result->id}}" >
									</label>
								</div>
							</td>
							<td>
								<div class="media-left media-middle">
									<a href="{{base_url('superuser/video/update/'.$result->id)}}">
										<img src="{{$result->img_src->md}}" class="img-circle img-xs" alt="">
									</a>
								</div>

								<div class="media-body">
									<a href="{{base_url('superuser/video/update/'.$result->id)}}" 
										class="display-inline-block text-semibold letter-icon-title">
										{{$result->name}}
									</a>
									<div class="text-muted text-size-small text-readmore">
										{{read_more($result->description)}}
									</div>
								</div>
							</td>
							<td>
								@if($result->type=="file")
									<span class="label label-primary label-icon">
										<i class=" icon-upload position-left"></i>
										Video File
									</span>
								@else
									<span class="label label-danger label-icon">
										<i class=" icon-youtube position-left"></i>
										Youtube URL
									</span>
								@endif
							</td>
							<td>
								<i class="text-info position-left icon-calendar22"></i> 
								{{tgl_indo($result->created_at)}}
							</td>
							<td>
								<div class="checkbox checkbox-switch">
									<label>
										<input onchange="changeStatus(this)" class="switch-status switch" data-id="{{$result->id}}" type="checkbox" data-off-text="Draft" data-on-text="Publish" data-on-color="success" data-off-color="default" data-size="mini" {{match($result->status,'publish','checked')}}>
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
											
											<li><a href="{{base_url('superuser/video/update/'.$result->id)}}">
												<i class=" icon-pencil7"></i> update data</a>
											</li>
											<li>
												<a data-url="{{base_url('superuser/video/remove/'.$result->id)}}" 
													href="javascript:void(0)" class="delete-url">
													<i class=" icon-trash"></i> Delete Data
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


@section('scripts')
	@include("pieces.js.datatable")
@endsection