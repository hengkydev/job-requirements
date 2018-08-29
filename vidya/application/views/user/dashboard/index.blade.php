@extends("user.template")

@section("breadcrumbs")
<ul class="breadcrumb">
	<li class="breadcrumb-item">
	  <a href="{{base_url("user")}}">Beranda</a>
	</li>
	<li class="breadcrumb-item">
	  <span>Selamat Datang, {{$__USER->name}}</span>
	</li>
</ul>
@endsection

@section("content")
 <div class="content-box">
    <div class="row">
      <div class="col-sm-12">
        <div class="element-wrapper">
          <h6 class="element-header">
            Dashboard Pengguna
          </h6>
          <div class="element-content">
            <div class="row">
              <div class="col-md-12">
                <div class="element-box el-tablo">
                  <h4>Selamat Datang, {{$__USER->name}} !</h4>
                  <div class="gap-xs"></div>
                  <div class="text-grey">
                    Selamat datang di sistem pengguna , anda dapat mengetahui informasi tentang kebutuhan 
                    investasi anda sesuai dengan menu yang telah di sediakan. apabila terdapat masalah
                    atau hal yang perlu di tanyakan silahkan hubungi kami untuk lebih lanjut 
                    <a href="#">
                      [Hubungi Kami]
                    </a>
                    <div class="gap-sm"></div>
                    Hormat Kami
                    <div class="gap-sm"></div>
                    <div class="text-sm">
                    <span class="position-left">-</span><b>Hawk1Hunter</b>
                  </div>  
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

