@extends("auth.user.template")

@section("content")

<div class="auth-box-w">

    <div class="logo-w">
      <a href="{{base_url()}}"><img alt="" src="{{base_url('userassets/img/logo-big.png')}}"></a>
    </div>
    <h4 class="auth-header">
      Login Form
    </h4>
    <form action="{{base_url('auth/user/authentication')}}" class="form-validate form-aksa-submit" data-type="notif" method="POST">
      <div class="form-group">
        <label for="">Username</label>
        <input class="form-control" placeholder="Enter your username" type="text" name="username" required="">
        <div class="pre-icon os-icon os-icon-user-male-circle"></div>
      </div>
      <div class="form-group">
        <label for="">Password</label><input class="form-control" placeholder="Enter your password" name="password" type="password">
        <div class="pre-icon os-icon os-icon-fingerprint"></div>
      </div>
      <div class="buttons-w">
        <button class="btn btn-primary" type="submit">Log me in</button>
        <div class="form-check-inline">
          <label class="form-check-label"><input class="form-check-input" type="checkbox">Remember Me</label>
        </div>
      </div>
    </form>
  </div>

@endsection

@section('scripts')
	@include("pieces.js.form")
@endsection