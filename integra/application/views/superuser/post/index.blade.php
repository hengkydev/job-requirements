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
			<form id="form-bulkaction" method="post" action="{{base_url('superuser/post/bulkaction')}}">
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
						<a href="{{base_url("superuser/post/create")}}" class="btn bg-pink btn-labeled heading-btn legitRipple" >
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
						<th width="250">Artikel</th>
						<th width="200">Pembuat</th>
						<th>Info</th>
						<th width="100">Khusus</th>
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
									<a href="{{base_url('superuser/post/update/'.$result->id)}}">
										<img src="{{$result->img_src->md}}" class="img-circle img-xs" alt="">
									</a>
								</div>

								<div class="media-body">
									<a href="{{base_url('superuser/post/update/'.$result->id)}}" title="{{$result->title}}" 
										class="display-inline-block text-semibold letter-icon-title text-readmore">
										{{$result->title}}
									</a>
									<div class="text-muted text-size-small text-readmore">
										{{read_more($result->description)}}
									</div>
								</div>
							</td>
							<td>
								<div class="media-body">
									<span class="text-info text-semibold text-readmore">{{$result->author}}</span>
									<i class=" icon-calendar22 position-left text-grey text-xs" title="Update Terakhir"></i>
									<span class="text-sm">{{tgl_indo($result->updated_at)}}</span>
								</div>
							</td>
							<td>
								<div class="text-readmore2">
									<span class="label bg-warning-400">{{$result->category->name}}</span>
								</div>
								<div class="gap-xs"></div>
								<div class="text-readmore text-sm text-grey-300">
									@foreach($result->tags as $key => $tag)
										@if($key > 5)
											@break
										@endif
										{{$tag->tag->name}} ,
									@endforeach
								</div>
							</td>
							<td>
								@if($result->access=="member")
									<span class="label bg-warning label-block" title="Khusus Member">Member</span>
								@else
									<span class="label bg-primary label-block" title="Khusus Publik">Publik</span>
								@endif
							</td>
							<td>
								<div class="checkbox checkbox-switch" title="Publish atau Draft data anda">
									<label>
										<input onchange="changeStatus(this)" class="switch-status switch" data-id="{{$result->id}}" type="checkbox" data-off-text='<i class=" icon-pencil5 text-grey-300"></i>' data-on-text='<i class=" icon-earth"></i>' data-on-color="success" data-off-color="default" data-size="mini" {{match($result->status,'publish','checked')}}>
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
											<li><a href="{{base_url('post/detail/'.$result->slug)}}" target="_blank" title="Lihat Artikel pada website">
												<i class="  icon-eye2"></i> Lihat Artikel</a>
											</li>
											<li class="divider"></li>
											<li><a href="{{base_url('superuser/post/update/'.$result->id)}}" title="Ubah Data">
												<i class=" icon-pencil7"></i> Ubah data</a>
											</li>
											<li>
												<a data-url="{{base_url('superuser/post/remove/'.$result->id)}}" 
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


@section('scripts')
	@include("pieces.js.datatable")
@endsection