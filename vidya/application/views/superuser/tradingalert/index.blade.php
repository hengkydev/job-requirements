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
			<form id="form-bulkaction" method="post" action="{{base_url('superuser/tradingalert/bulkaction')}}">
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
					<div class="col-md-2 text-right pull-right">
						<a href="{{base_url("superuser/tradingalert/create")}}" class="btn bg-pink btn-labeled heading-btn legitRipple" >
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
						<th width="50">Alert</th>
						<th width="250">Simbol</th>
						<th width="50">Power</th>
						<th>Remark</th>
						<th width="150">Tanggal</th>
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
								@if($result->alert)
									<i class=" icon-checkmark-circle text-success" title="Hawk1 Detected"></i>
								@else
									<i class=" icon-exclamation text-grey" title="Not Detected"></i>
								@endif
							</td>
							<td>
								<div class="media-left media-middle">
									<a href="{{base_url('superuser/tradingalert/update/'.$result->id)}}">
										<img src="{{$result->img_src->md}}" class="img-xs" alt="">
									</a>
								</div>
								<div class="media-body">
									<a href="{{base_url('superuser/tradingalert/update/'.$result->id)}}" title="{{$result->symbol}}" 
										class="display-inline-block text-semibold letter-icon-title text-readmore">
										{{$result->symbol}}
									</a>
								</div>
							</td>
							<td class="{{colorHawk1($result->power)}} text-center text-semibold text-lg">
	                            {{$result->power}}
	                        </td>
	                        <td>
	                        	<div class="text-readmore2">
	                        		{{read_more($result->remark)}}
	                        	</div>
	                        </td>
	                        <td>
	                        	{{tgl_indo($result->datetime)}}
	                        </td>
							<td class="text-center">
								<ul class="icons-list">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown">
											<i class="icon-menu9"></i>
										</a>

										<ul class="dropdown-menu dropdown-menu-right">
											<li><a href="{{base_url('superuser/tradingalert/update/'.$result->id)}}" title="Ubah Data">
												<i class=" icon-pencil7"></i> Ubah data</a>
											</li>
											<li>
												<a data-url="{{base_url('superuser/tradingalert/remove/'.$result->id)}}" 
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