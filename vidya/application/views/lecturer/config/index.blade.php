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
            <li><a href="{{base_url('student')}}"><i class="icon-home2 position-left"></i> Beranda</a></li>
            <li class="active">Beranda</li>
        </ul>
    </div>
</div>
@endsection

@section('content')
<form class="form-validate form-aksa-submit" action="{{$url_action}}" data-ckeditor data-type="redirect" method="POST" method="post" enctype="multipart/form-data">
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-flat">
            <div class="panel-body">
                <div class="form-group">
                    <label><b class="text-danger position-left">*</b>Nama Lengkap : </label>
                    <input type="text" name="name" value="{{@$table->name}}" class="form-control" placeholder="Ketikan nama pengajar di sini ..." required="">
                </div>
                <div class="form-group">
                    <label><b class="text-danger position-left">*</b>Jabatan : </label>
                    <input type="text" name="position" value="{{@$table->position}}" class="form-control" placeholder="Ketikan nama jabatan pengajar di sini ..." required="">
                </div>
                <div class="form-group">
                    <label class="display-block">
                        <b class="text-danger position-left">*</b>Jenis kelamin : 
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="gender" value="male" class="styled" 
                        {{match(@$table->gender,"male",'checked')}} required="" >
                        Laki Laki
                    </label>

                    <label class="radio-inline">
                        <input type="radio" name="gender" value="female" class="styled" 
                        {{match(@$table->gender,"female",'checked')}} required="" >
                        Perempuan
                    </label>
                </div>
                <div class="form-group has-feedback">
                    <label><b class="text-danger position-left">*</b>No Identitas  : </label>
                    <div class="input-group" style="display: block;">
                        <input type="text" name="identity_number" class="form-control xhr-input" data-url="{{base_url('datacollege/lectureridentityvalid')}}" data-exception="{{@$table->id}}" value="{{@$table->identity_number}}" placeholder="Masukan No Identitas di sini">
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
                        <input type="text" name="email" class="form-control xhr-input" value="{{@$table->email}}" data-url="{{base_url('datacollege/lectureremailvalid')}}" data-exception="{{@$table->id}}" placeholder="Masukan Email Pengajar di sini">
                    </div>
                    <div class="form-control-feedback">
                        <i class="icon-notification2"></i>
                    </div>
                    <div class="clearfix"></div>
                    <span class="help-block"></span>
                </div>
                
                <div class="form-group has-feedback has-feedback-left" 
                showhide-password 
                data-showclass="icon-eye2" 
                data-hideclass="icon-eye-blocked2"
                >

                    <label>
                        @if($type=="create")
                        <b class="text-danger position-left">*</b>
                        @endif
                        Ketik Kata Sandi : 
                    </label>
                    <div class="input-group">
                        <div class="form-control-feedback">
                            <i class="icon-lock2 text-muted"></i>
                        </div>
                        <input type="password" showhide-password-element name="password" class="form-control" placeholder="Ketik Kata Sandi minimal 8 karakter"  {{match($type,"create","required")}}>
                        
                        <span class="input-group-addon cursor-pointer">
                            <i class=" icon-eye-blocked2 text-grey" showhide-password-button data-popup="tooltip" title="Lihat / Sembunyikan password">
                            </i>
                        </span>
                    </div>
                    @if($type=="update")
                    <div class="help-block">
                        Jangan ubah kata sandi jika tidak ada perubahan
                    </div>
                    @endif
                </div>
            
                <div class="form-group has-feedback has-feedback-left" 
                showhide-password 
                data-showclass="icon-eye2" 
                data-hideclass="icon-eye-blocked2"
                >
                    <label>
                        @if($type=="create")
                        <b class="text-danger position-left">*</b>
                        @endif
                        Ketik Ulang Kata Sandi : 
                    </label>
                    <div class="input-group">
                        <div class="form-control-feedback">
                            <i class="icon-lock2 text-muted"></i>
                        </div>
                        <input type="password" showhide-password-element name="password_confirmation" class="form-control" placeholder="Ketik Kata Sandi minimal 8 karakter" {{match($type,"create","required")}}>
                        
                        <span class="input-group-addon cursor-pointer">
                            <i class=" icon-eye-blocked2 text-grey" showhide-password-button data-popup="tooltip" title="Lihat / Sembunyikan password">
                            </i>
                        </span>
                    </div>
                    @if($type=="update")
                    <div class="help-block">
                        Jangan ubah kata sandi jika tidak ada perubahan
                    </div>
                    @endif
                </div>
                <div class="form-group">
                    <label>No Telepon : </label>
                    <input type="text" name="phone" value="{{@$table->phone}}" class="form-control" placeholder="Ketikan no telepon" >
                </div>
                <div class="form-group">
                    <label>Alamat Pengajar : </label>
                    <textarea class="form-control" rows="4" name="address" placeholder="Alamat tempat tinggal Pengajar">{{@$table->address}}</textarea>
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
                                    <span class="filename" id="upload-text-1" style="user-select: none;">No file selected</span>
                                    <span class="action btn bg-pink-400 legitRipple" style="user-select: none;">Browse</span>
                                </div>
                            <span class="help-block no-margin text-sm">
                                Format : png, jpg. Maks 5Mb
                                @if($type=="update")
                                    , Jangan ubah jika tidak ada perubahan
                                @endif
                            </span>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
<div class="gap-sm"></div>
<div class="row">
    <div class="col-md-12">

        <button type="submit" class="btn bg-pink btn-labeled heading-btn legitRipple">
            <b><i class=" icon-arrow-right13"></i></b> Terapkan
        </button>
        <a href="javascript:void();" onclick="history.back();" class="btn bg-grey heading-btn legitRipple">
            Batalkan
        </a>
    </div>
</div>

</form>
@endsection

@section('scripts')
  @include("pieces.js.form")

@endsection