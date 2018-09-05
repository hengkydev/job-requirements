@extends("auth.student.template")

@section("content")
<div class="page-container">
  <!-- Page content -->
  <div class="page-content">
    <!-- Main content -->
    <div class="content-wrapper">
      <!-- Content area -->
      <div class="content no-padding">
        <!-- Advanced login -->
        <div class="col-md-8 margin-center">
          <div class="panel">
             <div class="panel-body">
                <h4 class="no-margin text-light media">
                  <div class="media-left">
                    <a href="#" class="btn border-pink text-pink btn-flat btn-rounded btn-icon btn-xs valign-text-bottom legitRipple ">
                      <i class=" icon-people"></i>
                  </a>
                  </div>
                   <div class="media-body">
                      Daftar Baru Sebagai <span class="text-semibold text-primary">Mahasiswa</span>
                      <div class="text-sm text-grey">
                        pendaftaran akun sistem e-learning sebagai mahasiswa
                      </div>
                   </div>
                </h4>
                <div class="gap-md"></div>
                <form action="{{base_url('auth/student/doregister')}}" class="form-validate form-aksa-submit" data-type="notif" method="POST">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                            <label><b class="text-danger position-left">*</b>Nama Lengkap : </label>
                            <input type="text" name="name" value="" class="form-control" placeholder="Ketikan nama pengguna di sini ..." required="">
                        </div>
                        <div class="form-group has-feedback">
                            <label><b class="text-danger position-left">*</b>No Identitas  : </label>
                            <div class="input-group" style="display: block;">
                              <input type="text" name="identity_number" class="form-control xhr-input" data-url="{{base_url('datacollege/studentidentityvalid')}}" data-exception="" value="" placeholder="Masukan No Identitas di sini">
                            </div>
                            <div class="form-control-feedback">
                              <i class="icon-notification2"></i>
                            </div>
                            <div class="clearfix"></div>
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group has-feedback">
                          <label><b class="text-danger position-left">*</b>Alamat Email : </label>
                          <div class="input-group" style="display: block;">
                            <input type="text" name="email" class="form-control xhr-input" value="" data-url="{{base_url('datacollege/studentemailvalid')}}" data-exception="" placeholder="Masukan Email Mahasiswa di sini">
                          </div>
                          <div class="form-control-feedback">
                            <i class="icon-notification2"></i>
                          </div>
                          <div class="clearfix"></div>
                          <span class="help-block"></span>
                        </div>
                        
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="display-block">
                            <b class="text-danger position-left">*</b>Jenis kelamin : 
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="gender" value="male" class="styled" required="" >
                            Laki Laki
                          </label>

                          <label class="radio-inline">
                            <input type="radio" name="gender" value="female" class="styled" required="" >
                            Perempuan
                          </label>
                          <div class="gap-sm"></div>
                        </div>
                        <div class="form-group has-feedback has-feedback-left" 
                          showhide-password 
                          data-showclass="icon-eye2" 
                          data-hideclass="icon-eye-blocked2"
                          >

                            <label>
                              <b class="text-danger position-left">*</b>
                              Ketik Kata Sandi : 
                            </label>
                            <div class="input-group">
                              <div class="form-control-feedback">
                                <i class="icon-lock2 text-muted"></i>
                              </div>
                              <input type="password" showhide-password-element name="password" class="form-control" placeholder="Ketik Kata Sandi minimal 8 karakter" required="">
                              
                              <span class="input-group-addon cursor-pointer">
                                <i class=" icon-eye-blocked2 text-grey" showhide-password-button data-popup="tooltip" title="Lihat / Sembunyikan password">
                                </i>
                              </span>
                            </div>
                          </div>
                        
                          <div class="form-group has-feedback has-feedback-left" 
                          showhide-password 
                          data-showclass="icon-eye2" 
                          data-hideclass="icon-eye-blocked2"
                          >
                            <label>
                              <b class="text-danger position-left">*</b>
                              Ketik Ulang Kata Sandi : 
                            </label>
                            <div class="input-group">
                              <div class="form-control-feedback">
                                <i class="icon-lock2 text-muted"></i>
                              </div>
                              <input type="password" showhide-password-element name="password_confirmation" class="form-control" placeholder="Ketik Kata Sandi minimal 8 karakter" >
                              
                              <span class="input-group-addon cursor-pointer">
                                <i class=" icon-eye-blocked2 text-grey" showhide-password-button data-popup="tooltip" title="Lihat / Sembunyikan password">
                                </i>
                              </span>
                            </div>
                          </div>
                      </div>
                      <div class="col-md-4">
                         <div class="form-group">
                            <label><b class="text-danger position-left">*</b>Nama Jurusan : </label>
                            <input type="text" name="department" value="" class="form-control" placeholder="Ketikan nama jurusan di sini ..." required="">
                        </div>

                        <div class="form-group">
                          <label><i class=" icon-image5 position-left text-primary"></i> Foto Profil :</label>
                          <div class="media no-margin-top">
                            <div class="media-left">
                              <a href="{{giveImageIfNull(@$table->img_src->xs,'image-lg')}}" class="fancybox upload-img-1" data-popup="lightbox">
                                <img class="upload-img-1" src="{{giveImageIfNull(@$table->img_src->xs,'image-xs')}}" style="width: 58px; height: 58px;object-fit: cover; border-radius: 2px;" alt="">
                              </a>
                            </div>

                            <div class="media-body">
                              <div class="uploader">
                                  <input type="file" class="file-styled uploader-preview-img" data-src=".upload-img-1" data-text="#upload-text-1" name="image">
                                  <span class="filename" id="upload-text-1" style="user-select: none;">No file</span>
                                  <span class="action btn bg-pink-400 legitRipple" style="user-select: none;">Browse</span>
                                </div>
                              <span class="help-block no-margin text-sm">
                                Format : png, jpg. Maks 5Mb
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                     <div class="row">
                      <div class="col-md-3">
                        <button type="submit" class="btn bg-pink btn-labeled heading-btn legitRipple">
                          <b><i class=" icon-arrow-right13"></i></b> Daftar
                        </button>
                      </div>
                      <div class="col-md-9 text-right">
                        <div class="help-block text-light text-right">
                          <span class="position-left">Atau Daftar Dengan</span>
                          <button type="button" class="btn bg-primary-800 ">
                            <i class=" icon-facebook2 position-left"></i>
                            Facebook
                          </button>
                           <button type="button" class="btn border-grey text-grey btn-flat btn-xs legitRipple">
                            <img src="{{base_url('mainassets/img/icon-google.png')}}" width="15" class="position-left" style="display: inline;">
                            Google
                          </button>
                        </div>
                      </div>
                    </div>
                </form>
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