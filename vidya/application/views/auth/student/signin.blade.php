@extends("auth.student.template")

@section("content")
<div class="page-container">
  <!-- Page content -->
  <div class="page-content">
    <!-- Main content -->
    <div class="content-wrapper">
      <!-- Content area -->
      <div class="content no-padding">
        <div class="gap-lg"></div>
        <!-- Advanced login -->
        <div class="col-md-8 margin-center">
          <div class="panel">
            <div class="row">
              <div class="col-md-7">
                <div class="panel-body bg-primary">
                  <h2 class="no-margin text-light">Sistem <span class="text-semibold">E-Learning</span></h2>
                  <span class="text-light">
                    Sistem Pembelajaran Online berbasis Website
                  </span>
                  <div class="gap-xs"></div>
                  <div class="row">
                    <div class="col-xs-6">
                      <div class="gap-md"></div>
                      <ul class="list list-icons no-margin-bottom">
                        <li>
                            <i class=" icon-books"></i> Materi Pembelajaran
                        </li>
                        <li><i class=" icon-comment-discussion"></i> Interaksi Mahasiswa dan Pengajar</li>
                        <li><i class=" icon-download"></i> Unduh Materi Pembelajaran</li>
                      </ul>
                      <div class="gap-md"></div>
                      <span class="text-light">
                        Apakah anda sudah memiliki akun ?<br>
                        Masuk sebagai 
                        <span class="text-semibold">Mahasiswa</span> /
                        <span class="text-semibold">Pengajar</span>
                      </span>
                      <div class="gap-sm"></div>
                      <div class="row">
                        <div class="col-sm-6">
                          <a href="{{base_url('auth/student')}}" class="btn btn-xs border-white text-white btn-flat legitRipple btn-block">
                            Mahasiswa
                          </a>
                        </div>
                        <div class="col-sm-6">
                           <a href="{{base_url('auth/lecturer')}}" class="btn btn-xs border-white text-white btn-flat legitRipple btn-block">
                            Pengajar
                          </a>
                        </div>
                      </div>
                    </div>
                    <div class="col-xs-6">
                      <img src="{{base_url('mainassets/img/figure.png')}}" width="250">
                    </div>
                  </div>
                  <div class="text-thin">
                    Aplikasi ini di tujukan kepada :
                    <div class="gap-xs"></div>
                    <img src="{{base_url('mainassets/img/github.png')}}" width="60">&nbsp;
                    <img src="{{base_url('mainassets/img/logo_evima.png')}}" width="60">
                  </div>
                </div>
              </div>
              <div class="col-md-5">
                <div class="panel-body">
                  <h4 class="no-margin text-light media">
                    <div class="media-left">
                      <a href="#" class="btn border-pink text-pink btn-flat btn-rounded btn-icon btn-xs valign-text-bottom legitRipple "><i class="icon-enter"></i>
                    </a>
                    </div>
                     <div class="media-body">
                        Masuk Sebagai <span class="text-semibold text-primary">Mahasiswa</span>
                        <div class="text-sm text-grey">
                          masuk sistem e-learning sebagai mahasiswa
                        </div>
                     </div>
                  </h4>
                  <div class="gap-md"></div>
                  <form action="{{base_url('auth/superuser/authentication')}}" class="form-validate form-aksa-submit" data-type="notif" method="POST">
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

                        <div class="form-group">
                          <button type="submit" class="btn bg-pink-400 btn-block" element-grecaptcha>
                            Masuk sistem
                            <i class="icon-circle-right2 position-right"></i>
                          </button>
                        </div>
                  </form>
                  <div class="help-block text-light text-center">
                    Belum mempunyai akun <span class="text-semibold">Mahasiswa</span> ?  
                    <a href="{{base_url('auth/student/register')}}"><u>Daftar Sekarang</u></a>
                  </div>
                  <div class="content-divider text-muted form-group"><span>Atau Daftar Dengan</div>
                  <div class="row">
                    <div class="col-sm-6">
                      <button type="button" class="btn bg-primary-800 btn-block">
                        <i class=" icon-facebook2 position-left"></i>
                        Facebook
                      </button>
                    </div>
                    <div class="col-sm-6">
                      <button type="button" class="btn border-grey text-grey btn-flat btn-block btn-xs legitRipple">
                        <img src="{{base_url('mainassets/img/icon-google.png')}}" width="15" class="position-left" style="display: inline;">
                        Google
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="text-center">
            <img src="{{base_url('mainassets/img/logo_evima.png')}}" width="100">
            <div class="gap-xs"></div>
            Aplikasi ini di buat dengan tujuan menyelesaikan test penerimaan pekerjaan pada
            <br>
            <a href="http://sevima.com/" target="_blank">
              PT. Sentra Vidya Utama 
            </a>
            di buat oleh <a href="https://github.com/hengkydev/" target="_blank">Hengky Irianto</a>
          </div>
        </div>

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