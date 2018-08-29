<!DOCTYPE html>
<html lang="en" >
	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>
			Signin | Aksamedia Management Projects
		</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
          WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
		</script>
		<!--end::Web font -->
        <!--begin::Base Styles -->
		<link href="/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
		<link href="/assets/demo/demo6/base/style.bundle.css" rel="stylesheet" type="text/css" />
		<link href="/main_assets/css/default.css" rel="stylesheet" type="text/css" />
		<!--end::Base Styles -->
		<link rel="shortcut icon" href="/contents/icon.png" />
		<style type="text/css">
			body {
				background: linear-gradient(to right, #3b0f6af5 0%, #2575fcbd 100%),url(https://source.unsplash.com/1600x790/daily/?mountain);
				background-size: cover;
				background-attachment: fixed;
				background-repeat: no-repeat;
				background-position: center;

			}
		</style>
	</head>
	<!-- end::Head -->
    <!-- end::Body -->

	<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1" id="m_login">
				<div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
					<div class="m-login__container">
						<div class="m-login__logo" style="margin-bottom:20px;">
							<a href="#">
								<img src="/contents/icon-white.png" width="120"	>
							</a>
						</div>
						<div class="m-login__signin">
							<div class="m-login__head">
								<h3 class="m-login__title">
									AKSAMEDIA
								</h3>
								<div class="text-center text-white">
									  Sistem Manajemen Proyek
								</div>
							</div>
							<div id="alert-showing">
								
							</div>
							
							<form id="form-data" class="m-login__form m-form" action="{{base_url('authentication/user')}}" style="margin-top:30px;">
								<div class="form-group m-form__group has-danger">
									<input class="form-control m-input"  type="text" placeholder="Username" name="username" autocomplete="off">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password">
								</div>
								<div class="row m-login__form-sub">
									<div class="col m--align-left m-login__form-left">
										<label class="m-checkbox  m-checkbox--light">
											<input type="checkbox" name="remember">
											Remember me
											<span></span>
										</label>
									</div>
									<div class="col m--align-right m-login__form-right">
										<a href="javascript:;" id="m_login_forget_password" class="m-link">
											Forget Password ?
										</a>
									</div>
								</div>
								<div class="m-login__form-action">
									<button id="m_login_signin_submit"  data-sitekey="{{getEnv('GOOGLE_RECAPTCHA_SITE')}}" data-callback="recaptchaSubmit"  class="g-recaptcha btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary">
										Sign In
									</button>
								</div>
							</form>
						</div>
						<div class="m-login__forget-password">
							<div class="m-login__head">
								<h3 class="m-login__title">
									Forgotten Password ?
								</h3>
								<div class="m-login__desc">
									Enter your email to reset your password:
								</div>
							</div>
							<form class="m-login__form m-form" action="">
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="Email" name="email" id="m_email" autocomplete="off" required="">
								</div>
								<div class="m-login__form-action">
									<button id="m_login_forget_password_submit" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
										Request
									</button>
									&nbsp;&nbsp;
									<button id="m_login_forget_password_cancel" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">
										Cancel
									</button>
								</div>
							</form>
						</div>
						<div class="m-login__account">
							<span class="m-login__account-msg">
								Sistem Manajemen Proyek - 2018
							</span>
							&nbsp;&nbsp;
							<a href="http://aksamedia.co.id" class="m-link m-link--light m-login__account-link">
								AKSAMEDIA
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end:: Page -->
    	<!--begin::Base Scripts -->
		<script src="/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
		<script src="/assets/demo/demo6/base/scripts.bundle.js" type="text/javascript"></script>
		<!--end::Base Scripts -->   
        <!--begin::Page Snippets -->
		<script type="text/javascript" src="/main_assets/js/library.js"></script>
		<script type="text/javascript" src="/main_assets/js/metronic.js"></script>
		<script type="text/javascript" src="/main_assets/js/form_auth_recaptcha.js"></script>
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<!--end::Page Snippets -->
	</body>
	<!-- end::Body -->
</html>
