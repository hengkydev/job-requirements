@extends('error.template')

@section('title')
Maaf Wesite Replika Sedang Tidak Di Aktifkan
@stop


@section('content')
    <div class="col-md-8 margin-center">
       <div class="panel panel-success">
            <div class="panel-heading">
                <h6 class="panel-title text-center">Opps! ,  Maaf Website Replika Sedang Di Non Aktifkan</h6>
            </div>
            
            <div class="panel-body">
                <div class="gap-md"></div>
                
                <div class="col-md-4 text-center margin-center">
                    <img src="{{$config->logofile}}" class="img-responsive">
                </div>                
                <div class="gap"></div>
                <article class="error-explain col-md-9 margin-center text-justify text-muted">
                    <b>Web Replika Di Non Aktifkan </b> - Mohon maaf web replika yang anda akses dengan nama subdomain 
                    <span class="text-primary">{{@$_SERVER['SERVER_NAME']}}</span> sedang tidak dapat di akses atau sedang 
                    di non aktifkan oleh pihak kami , untuk mengetahui masalah ini lebih lanjut silahkan hubungi
                    <br><br>
                    @if($contact['auth']==false)
                         <table style="width:100%;">
                            <tr>
                                <td width="120"><b>Nama Lengkap</b></td>
                                <td>: {{$config->name}}</td>
                            </tr>
                            <tr>
                                <td width="120"><b>Email</b></td>
                                <td>: <a href="mailto:{{$config->email}}"> {{$config->email}}</a></td>
                            </tr>
                            <tr>
                                <td><b>No Telp</b></td>
                                <td>: <a href="tel://{{$config->phone}}"> {{$config->phone}}</a></td>
                            </tr>
                            <tr>
                                <td><b>Alamat</b></td>
                                <td>: {{$config->address}}</td>
                            </tr>
                        </table>
                    @else
                        <table style="width:100%;">
                            <tr>
                                <td width="120"><b>Nama Lengkap</b></td>
                                <td>: {{$contact['msg']->name}}</td>
                            </tr>
                            <tr>
                                <td width="120"><b>Email</b></td>
                                <td>: <a href="mailto:{{$contact['msg']->email}}"> {{$contact['msg']->email}}</a></td>
                            </tr>
                            <tr>
                                <td><b>No Telp</b></td>
                                <td>: <a href="tel://{{$contact['msg']->phone}}"> {{$contact['msg']->phone}}</a></td>
                            </tr>
                            <tr>
                                <td><b>Whatsapp</b></td>
                                <td>: <a href="intent://send/{{$contact['msg']->whatsapp}};scheme=smsto;package=com.whatsapp;action=android.intent.action.SENDTO;end"> {{$contact['msg']->whatsapp}}</a></td>
                            </tr>
                            <tr>
                                <td><b>Pin BB</b></td>
                                <td>: <a href="http://pin.bbm.com/{{$contact['msg']->pinbb}}"> {{$contact['msg']->pinbb}}</a></td>
                            </tr>
                            <tr>
                                <td><b>Alamat</b></td>
                                <td>: {{$contact['msg']->address}}</td>
                            </tr>
                        </table>
                    @endif
                    <br>
                </article>
                <article class="error-explain col-md-9 margin-center text-center text-muted">
                    Best Regards<br>
                    <i>{{$config->name}}</i>
                </article>
            </div>
        </div>
    </div>
@stop