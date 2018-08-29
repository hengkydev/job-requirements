@extends('error.template')

@section('title')
Opss! Page Not Found
@stop


@section('content')
    <div class="col-md-8 margin-center">
       <div class="panel panel-success">
            <div class="panel-heading">
                <h6 class="panel-title text-center">Opps! ,  Maaf Halaman yang Anda Cari Tidak Di Temukan</h6>
            </div>
            
            <div class="panel-body">
                <div class="gap-md"></div>
                
                <div class="col-md-4 text-center margin-center">
                    <img src="{{$config->logofile}}" class="img-responsive">
                </div>                
                <div class="gap"></div>
                <article class="error-explain col-md-9 margin-center text-justify text-muted">
                    <b>Error Code 404 </b> - 
                    Maaf Kami Tidak menemukan halaman apapun di website kami mengenai url yang anda cari yaitu 
                    <span class="text-primary">{{@$_SERVER['REDIRECT_URL']}}</span> silahkan pastikan apakah url yang anda maksud 
                    telah benar , atau silahkan <a href="{{base_url('main/contact')}}">Hubungi Kami</a>  kami untuk lebih lanjut , atau anda
                    bisa kembali ke halaman utama kami <br><br>
                </article>
                <article class="error-explain col-md-9 margin-center text-center text-muted">
                    Best Regards<br>
                    <i>{{$config->name}}</i>
                </article>
            </div>
        </div>
    </div>
@stop