@extends('lecturer.template')

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
            <li><a href="{{base_url('lecturer')}}"><i class="icon-home2 position-left"></i> Beranda</a></li>
            <li class="active">Beranda</li>
        </ul>
    </div>
</div>
@endsection

@section("content")
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-flat panel-body">
			<form id="form-bulkaction" method="post" action="{{base_url('lecturer/materi/bulkaction')}}">
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
							<option value="delete">Hapus data</option>
						</select>
					</div>
					<div class="col-md-2">
						<button type="submit" class="btn bg-purple btn-xs">
							<i class="icon-check position-left"></i> Action
						</button>
					</div>
					<div class="col-md-6 text-right pull-right">
						<a href="{{base_url("lecturer/materi/create")}}" class="btn bg-pink btn-labeled heading-btn legitRipple" >
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
						<th width="250">Materi</th>
						<th width="200">Info</th>
						<th width="200">Pembuat</th>
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
									<a href="{{base_url('lecturer/materi/detail/'.$result->id)}}">
										<img src="{{$result->img_src->md}}" class="img-circle img-xs" alt="">
									</a>
								</div>

								<div class="media-body">
									<a href="{{base_url('lecturer/materi/update/'.$result->id)}}" title="{{$result->title}}" 
										class="display-inline-block text-semibold letter-icon-title text-readmore">
										{{$result->name}}
									</a>
									<div class="text-muted text-size-small text-readmore">
										{{read_more($result->description)}}
									</div>
								</div>
							</td>
							<td>
								<div class="media-body">
									<span class="text-info text-semibold text-readmore" title="File yang disisipkan">
										<i class="text-muted text-xs   icon-attachment position-left"></i>
										{{$result->attachments->count()}} file 
									</span>
									<span class="text-info text-semibold text-readmore" title="Komentar Materi">
										<i class="text-muted text-xs   icon-comment-discussion position-left"></i>
										{{$result->comments->count()}} Komentar
									</span>
								</div>
							</td>
							<td>
								<div class="media">
					                <div class="media-left">
					                    <a href="{{$result->lecturer->img_src->lg}}" data-popup="lightbox">
					                        <img src="{{$result->lecturer->img_src->lg}}" style="width: 70px; height: 70px;" class="img-circle img-md" alt="">
					                    </a>
					                </div>

					                <div class="media-body">
					                    <h6 class="media-heading">{{$result->lecturer->name}}</h6>
					                    <p class="text-muted">{{$result->lecturer->position}}</p>
					                </div>
					            </div>
							</td>
							<td class="text-center">
								<ul class="icons-list">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown">
											<i class="icon-menu9"></i>
										</a>
										<ul class="dropdown-menu dropdown-menu-right">
											<li><a href="{{base_url('lecturer/materi/detail/'.$result->id)}}" title="Lihat materi">
												<i class="  icon-eye2"></i> Lihat data </a>
											</li>
											<li><a href="{{base_url('lecturer/materi/update/'.$result->id)}}" title="Ubah Data">
												<i class=" icon-pencil7"></i> Ubah data</a>
											</li>
											<li>
												<a data-url="{{base_url('lecturer/materi/remove/'.$result->id)}}" 
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