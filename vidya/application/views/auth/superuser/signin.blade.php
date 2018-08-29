@extends("auth.superuser.template")

@section("content")
<div class="page-container">
	<!-- Page content -->
	<div class="page-content">
		<!-- Main content -->
		<div class="content-wrapper">
			<!-- Content area -->
			<div class="content no-padding">
				<div class="gap-md"></div>
				<!-- Advanced login -->
				<form action="{{base_url('auth/superuser/authentication')}}" class="form-validate form-aksa-submit" data-type="notif" method="POST">
					<div class="panel login-form">
						<div class="panel-body bg-gradient-wallpaper">
							<div class="text-center">
								<img src="{{$__INFO->icon_white_dir->sm}}" width="120">
								<div class="gap-sm"></div>
								<h5 class="content-group-lg no-margin text-white">Sistem Konten Manajemen
									<small class="display-block text-white opacity-8">Masukkan kredensial anda</small>
								</h5>
								<div class="gap-sm"></div>
							</div>
						</div>
						
						<div class="panel-body">
							<div class="form-group has-feedback has-feedback-left">
								<input type="text" name="username" class="form-control" placeholder="Nama pengguna" required="">
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
							</div>

							<div class="form-group has-feedback has-feedback-left" 
							showhide-password 
							data-showclass="icon-eye2" 
							data-hideclass="icon-eye-blocked2"
							>
								<div class="input-group">
									<div class="form-control-feedback">
										<i class="icon-lock2 text-muted"></i>
									</div>
									<input type="password" showhide-password-element name="password" class="form-control" placeholder="Kata Sandi" required="">
									
									<span class="input-group-addon cursor-pointer">
										<i class=" icon-eye-blocked2 text-grey" showhide-password-button data-popup="tooltip" title="Lihat / Sembunyikan password">
										</i>
									</span>
								</div>
							</div>


							<div class="form-group login-options">
								<div class="row">
									<div class="col-sm-6">
										<label class="checkbox-inline text-grey">
											<input type="checkbox" name="remember" class="styled">
											Ingat Saya
										</label>
									</div>

									<div class="col-sm-6 text-right">
										<a href="login_password_recover.html"> Lupa kata sandi ?</a>
									</div>
								</div>
							</div>

							<div class="form-group">
								<button type="submit" class="btn bg-pink-400 btn-block" element-grecaptcha>
									Masuk sistem
									<i class="icon-circle-right2 position-right"></i>
								</button>
							</div>
							<div class="content-divider text-muted form-group"><span><img src="{{$__INFO->logo_dir->xs}}"  width="100"></span></div>
							<span class="help-block text-center no-margin">
							© {{date('Y')}} <a href="http://aksamedia.com"> Aksamedia</a> . Sistem Konten Manajemen v.2
						</div>
					</div>
				</form>

				<!-- /advanced login -->

			</div>
			<!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

</div>
@endsection

@section('scripts')
	@include("pieces.js.form")
@endsection