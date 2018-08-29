<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>API Service documentation - {{$__CONFIG->name}}</title>
	<meta name="robots" content="NOINDEX,NOFOLLOW">
	<link rel="icon" type="image/png" href="{{$__CONFIG->icon_sm_dir}}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{$__CONFIG->icon_xs_dir}}" sizes="16x16">

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="/panel_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="/panel_assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="/panel_assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="/panel_assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="/panel_assets/css/colors.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="/panel_assets/css/root.css">
	<link rel="stylesheet" type="text/css" href="/main_assets/css/default.css">

	<!-- /global stylesheets -->
	
	<!-- /theme JS files -->

</head>

<body class="login-container">
	<div class="bg-wallpaper">
	<!-- Main navbar -->
	<!-- /main navbar -->

			<!-- Page container -->
			<div class="page-container">

				<!-- Page content -->
				<div class="page-content">

					<!-- Main content -->
					<div class="content-wrapper">

						<!-- Content area -->
						<div class="content">

							<!-- Simple login form -->
							<div class="row">
								<div class="col-md-12">
									<div class="panel panel-flat pt-10 pb-10 pl-20 pr-20">
										<div class="row">
											<div class="col-sm-2">
												<img src="{{$__CONFIG->logo_sm_dir}}" class="content-group mt-10" alt="" style="width: 120px;">
											</div>
											<div class="col-sm-4">
												
											</div>
											<div class="col-sm-6 text-right">
												<ul class="list-condensed list-unstyled">
													<li>2269 Elba Lane</li>
												</ul>
											</div>
										</div>
										<div>
											<div class="help-block text-grey no-margin">
												Informasi untuk API servis setiap warna bar tabel mewakili artian berikut :	 
												&nbsp;&nbsp;&nbsp;
												<span class="status-mark border-info position-left"></span> Baru &nbsp;&nbsp;&nbsp;
												<span class="status-mark border-warning position-left"></span> Di Perbarui
											</div>
										</div>
									</div>
									@foreach($category as $result)
									<div class="panel panel-flat">
										<div class="panel-heading border-top-xlg border-top-blue">
											<h6 class="panel-title">{{$result->name}} <a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
											<div class="heading-elements">
												<ul class="icons-list">
							                		<li><a data-action="collapse"></a></li>
							                		<li><a data-action="reload"></a></li>
							                		<li><a data-action="close"></a></li>
							                	</ul>
						                	</div>
										</div>
										<div class="panel-body">
											<div class="help-block text-grey no-margin">
												{!! $result->description !!}
											</div>
										</div>
										<table class="table table-hover">
											<thead >
												<tr class="bg-info">
													<th width="5" align="center" class="text-center"><i class="icon-arrow-down12"></i></th>
													<th width="80">Name</th>
													<th width="80">Method</th>
													<th width="300">URL</th>
													<th width="500">Data</th>
												</tr>
											</thead>
											<tbody>
												@foreach($result->api as $api)
												<tr>
													<td align="center" title="Working Fine">
														<i class="icon-checkmark-circle text-success"></i>
													</td>
													<td>
														
														<div class="media-body">
															<a href="#" class="display-inline-block text-semibold letter-icon-title text-readmore">
																{{$api->name}}
															</a>
															<div class="gap-xs"></div>
															<a href="javascript:void(0)" data-popup="popover" data-placement="bottom" title="{{$api->name}}" data-content="{{$api->description}}" data-trigger="hover" class="text-warning text-size-mini">
															[Hover To View Description]
															</a>
															<div class="gap-xs"></div>
															<div class="text-muted text-size-mini text-readmore">
																<span class="status-mark border-blue position-left"></span>
																<span class="text-muted text-semibold">{{tgl_indo($api->created_at)}}</span>
																&nbsp;&nbsp;
																<span class="status-mark border-warning position-left"></span>
																<span class="text-muted text-semibold">{{tgl_indo($api->updated_at)}}</span>
															</div>
														</div>
													</td>
													<td align="center">
														{!! $api->method_label !!}
													</td>
													<td>
														<a href="{{base_url('getdata/general')}}" class="display-inline-block text-semibold text-readmore" title="Klik link untuk copy ke clipboard">
															<u>{{ base_url($api->url) }}</u>
														</a>
													</td>
													<td>
														@if($api->auth_required>0)
														<div class="row">
																<div class="col-sm-3">
																	<span class="label text-lowercase-important bg-info label-block">
																		Authentication
																	</span>
																</div>
																<div class="col-sm-9 text-size-mini text-grey-300">
																	Header Authentication Required -> user authentication
																</div>
															</div>
															<div class="gap-xs"></div>
														@endif
														@foreach($api->data as $data)
															<div class="row">
																<div class="col-sm-3">
																	@if($data->required>0)
																	<span class="label text-lowercase-important label-warning label-block">{{$data->name}}</span>
																	@else
																	<span class="label text-lowercase-important label-default label-block">{{$data->name}}</span>
																	@endif
																</div>
																<div class="col-sm-9 text-size-mini text-grey-300">
																	@if($data->required>0)
																	<span class="status-mark border-warning position-left"></span>
																	@else
																	<span class="status-mark border-grey-300 position-left"></span>
																	@endif
																	{{$data->description}} 
																</div>
															</div>
															<div class="gap-xs"></div>
														@endforeach
													</td>
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>
									@endforeach
								</div>
							</div>
							<!-- /simple login form -->


							<!-- Footer -->
							<div class="footer text-white text-center">
								© 2017. <a href="http://aksamedia.com" class="text-info" target="_blank">Aksamedia</a> Web Base System Version 1.0 								
							</div>
							<!-- /footer -->

						</div>
						<!-- /content area -->

					</div>
					<!-- /main content -->

				</div>
				<!-- /page content -->

			</div>

	</div>
	<!-- /page container -->
	<!-- Core JS files -->

	<script type="text/javascript" src="/panel_assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="/panel_assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="/panel_assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="/panel_assets/js/plugins/notifications/jgrowl.min.js"></script>
	<script type="text/javascript" src="/panel_assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->
	<!-- Theme JS files -->
	<script type="text/javascript" src="/panel_assets/js/core/app.js"></script>
	<script type="text/javascript" src="/panel_assets/js/pages/components_popups.js"></script>
	<script type="text/javascript" src="/main_assets/js/library.js"></script>
	<script type="text/javascript" src="/main_assets/js/limitless_lib.js"></script>
</body>
</html>
