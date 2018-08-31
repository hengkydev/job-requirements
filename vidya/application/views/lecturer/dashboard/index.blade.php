@extends("lecturer.template")


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
  <div class="panel panel-flat panel-body">
    <h5 class="text-light no-margin"> Selamat Datang di Sistem <span class="text-semibold text-primary ">E-Learning</span></h5>
    <div class="gap-xs"></div>
    <article class="text-light">
        Ini Merupakan sistem e-learning khusus pengajar dengan komposisi fitur Materi, Beranda, Pengaturan profil serta kolom komentar
        pada materi. sistem ini di bangun dengan tujuan menyelesaikan test interview lanjutan dari 
        <span class="text-primary">PT. Sentra Vidya Utama</span>
        <div class="gap-xs"></div>
        <span class="text-semibold">Terima Kasih</span> telah memberikan kesempatan saya untuk mengikuti ujian penerimaan sebelumnya
        <div class="gap-sm"></div>
        Hormat Saya
        <div class="gap-xs"></div>
        <a href="http://github.com/hengkydev" class="text-semibold">
            Hengky Irianto
        </a>
    </article>
  </div>
@endsection

@section('scripts')
  @include("pieces.js.form")
@endsection