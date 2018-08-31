<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{$__INFO->name}} - @yield('title',"Beranda")</title>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">

	<link rel="icon" href="{{$__INFO->icon_dir->xs}}" type="image/png" sizes="16x16">
	<link rel="icon" href="{{$__INFO->icon_dir->xs}}" type="image/png" sizes="32x32">
	<link rel="icon" href="{{$__INFO->icon_dir->sm}}" type="image/png" sizes="120x120">
	<link rel="icon" href="{{$__INFO->icon_dir->md}}" type="image/png" sizes="240x240">

	@yield("meta")

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{base_url('panelassets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
	<link href="{{base_url('panelassets/css/bootstrap.css')}}" rel="stylesheet" type="text/css">
	<link href="{{base_url('panelassets/css/core.css')}}" rel="stylesheet" type="text/css">
	<link href="{{base_url('panelassets/css/components.css')}}" rel="stylesheet" type="text/css">
	<link href="{{base_url('panelassets/css/colors.css')}}" rel="stylesheet" type="text/css">
	<link href="{{base_url('mainassets/css/default.css')}}" rel="stylesheet" type="text/css">
	@yield("styles")
	<!-- /global stylesheets -->
</head>

<body>

	<!-- Main navbar -->
	<div class="navbar navbar-default header-highlight">
		<div class="navbar-header text-center">
			<a class="navbar-brand" href="{{base_url('/')}}">
				<img src="{{$__INFO->logo_white_dir->sm}}" alt="">
			</a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-puzzle3"></i>
						<span class="visible-xs-inline-block position-right">Git updates</span>
						<span class="status-mark border-pink-300"></span>
					</a>				
				</li>
			</ul>

			<div class="navbar-right">
				<p class="navbar-text">Selamat Datang, {{$__SUPERUSER->name}}</p>
				<p class="navbar-text"><span class="label bg-success">Online</span></p>
				
				<ul class="nav navbar-nav">				
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-bell2"></i>
							<span class="visible-xs-inline-block position-right">Activity</span>
							<span class="status-mark border-pink-300"></span>
						</a>

						<div class="dropdown-menu dropdown-content">
							<div class="dropdown-content-heading">
								Activity
								<ul class="icons-list">
									<li><a href="#"><i class="icon-menu7"></i></a></li>
								</ul>
							</div>

							<ul class="media-list dropdown-content-body width-350">
								<li class="media">
									<div class="media-left">
										<a href="#" class="btn bg-success-400 btn-rounded btn-icon btn-xs"><i class="icon-mention"></i></a>
									</div>

									<div class="media-body">
										<a href="#">Taylor Swift</a> mentioned you in a post "Angular JS. Tips and tricks"
										<div class="media-annotation">4 minutes ago</div>
									</div>
								</li>

								<li class="media">
									<div class="media-left">
										<a href="#" class="btn bg-pink-400 btn-rounded btn-icon btn-xs"><i class="icon-paperplane"></i></a>
									</div>
									
									<div class="media-body">
										Special offers have been sent to subscribed users by <a href="#">Donna Gordon</a>
										<div class="media-annotation">36 minutes ago</div>
									</div>
								</li>

								<li class="media">
									<div class="media-left">
										<a href="#" class="btn bg-blue btn-rounded btn-icon btn-xs"><i class="icon-plus3"></i></a>
									</div>
									
									<div class="media-body">
										<a href="#">Chris Arney</a> created a new <span class="text-semibold">Design</span> branch in <span class="text-semibold">Limitless</span> repository
										<div class="media-annotation">2 hours ago</div>
									</div>
								</li>

								<li class="media">
									<div class="media-left">
										<a href="#" class="btn bg-purple-300 btn-rounded btn-icon btn-xs"><i class="icon-truck"></i></a>
									</div>
									
									<div class="media-body">
										Shipping cost to the Netherlands has been reduced, database updated
										<div class="media-annotation">Feb 8, 11:30</div>
									</div>
								</li>

								<li class="media">
									<div class="media-left">
										<a href="#" class="btn bg-warning-400 btn-rounded btn-icon btn-xs"><i class="icon-bubble8"></i></a>
									</div>
									
									<div class="media-body">
										New review received on <a href="#">Server side integration</a> services
										<div class="media-annotation">Feb 2, 10:20</div>
									</div>
								</li>

								<li class="media">
									<div class="media-left">
										<a href="#" class="btn bg-teal-400 btn-rounded btn-icon btn-xs"><i class="icon-spinner11"></i></a>
									</div>
									
									<div class="media-body">
										<strong>January, 2016</strong> - 1320 new users, 3284 orders, $49,390 revenue
										<div class="media-annotation">Feb 1, 05:46</div>
									</div>
								</li>
							</ul>
						</div>
					</li>					
				</ul>
			</div>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<div class="sidebar sidebar-main">
				<div class="sidebar-content">

					@include('superuser.pieces.sidebar')

				</div>
			</div>
			<!-- /main sidebar -->


			<!-- Main content -->
			<div class="content-wrapper">


				<div class="content">
					@if($hasSuccess)
					<div class="alert bg-success alert-styled-left">
						<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
						<span class="text-semibold">Sukses</span> {{$hasSuccess}} 
				    </div>
				    @elseif($hasError)
				    <div class="alert bg-danger alert-styled-left">
						<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
						<span class="text-semibold">Kesalahan!</span> {{$hasError}} 
				    </div>
				    @endif
					@yield("heading")

					@yield("content")

					<!-- Footer -->
					<div class="footer text-muted">
						&copy; {{date("Y")}}. Sistem ini du buat oleh <a href="http://aksamedia.com">Aksamedia</a>
					</div>
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

	@yield("footer")
	
	<!-- Core JS files -->
	@include("pieces.env.scripts")

	<script type="text/javascript" src="{{base_url('panelassets/js/plugins/loaders/pace.min.js')}}"></script>
	<script type="text/javascript" src="{{base_url('panelassets/js/core/libraries/jquery.min.js')}}"></script>
	<script type="text/javascript" src="{{base_url('panelassets/js/core/libraries/bootstrap.min.js')}}"></script>
	<script type="text/javascript" src="{{base_url('panelassets/js/plugins/loaders/blockui.min.js')}}"></script>
	<script type="text/javascript" src="{{base_url('panelassets/js/plugins/ui/nicescroll.min.js')}}"></script>
	<script type="text/javascript" src="{{base_url('panelassets/js/plugins/ui/drilldown.js')}}"></script>
	<script type="text/javascript" src="{{base_url('panelassets/js/plugins/media/fancybox.min.js')}}"></script>

	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="{{base_url('panelassets/js/plugins/forms/styling/switchery.min.js')}}"></script>
	<script type="text/javascript" src="{{base_url('panelassets/js/plugins/forms/styling/uniform.min.js')}}"></script>
	<script type="text/javascript" src="{{base_url('panelassets/js/plugins/ui/moment/moment.min.js')}}"></script>
	<script type="text/javascript" src="{{base_url('panelassets/js/plugins/notifications/sweet_alert.min.js')}}"></script>
	<script type="text/javascript" src="{{base_url('panelassets/js/plugins/notifications/pnotify.min.js')}}"></script>
	<script type="text/javascript" src="{{base_url('panelassets/js/plugins/notifications/noty.min.js')}}"></script>
	<script type="text/javascript" src="{{base_url('panelassets/js/plugins/notifications/jgrowl.min.js')}}"></script>

	<script type="text/javascript" src="{{base_url('panelassets/js/core/app.js')}}"></script>

	<script type="text/javascript" src="{{base_url('panelassets/js/plugins/ui/ripple.min.js')}}"></script>
	<!-- /theme JS files -->
	@yield("scripts")
	<script type="text/javascript" src="{{base_url('mainassets/js/library.js')}}"></script>
</body>
</html>
