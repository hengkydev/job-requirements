@extends('lecturer.template')

@section('title')
{{$head_text}}
@endsection

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
            <li><a href="{{base_url('student/materi')}}">Materi</a></li>
            <li class="active">Detail Materi</li>
        </ul>
    </div>
</div>
@endsection

@section("content")
<div class="panel panel-body panel-flat">
    <div class="row">
        <div class="col-sm-8">
            <h5 class="text-primary no-margin">{{$table->name}}</h5>
            <div class="help-block text-light text-sm">
                di buat pada : {{tgl_indo($table->created_at)}}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="media">
                <div class="media-left">
                    <a href="{{$table->lecturer->img_src->lg}}" data-popup="lightbox">
                        <img src="{{$table->lecturer->img_src->lg}}" style="width: 70px; height: 70px;" class="img-circle img-md" alt="">
                    </a>
                </div>

                <div class="media-body">
                    <h6 class="media-heading">{{$table->lecturer->name}}</h6>
                    <p class="text-muted">{{$table->lecturer->position}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="gap-sm"></div>
    <article>
        {!! $table->description !!}
    </article>
    <div class="gap-sm"></div>
    <i class="icon-attachment position-left text-warning"></i> <span class="text-primary position-left">{{$table->attachments->count()}}</span>File yang di sisipkan pada materi
    <div class="gap-sm"></div>
    <div class="row">
    @foreach($table->attachments as $result)
     <div class="col-sm-2">
        <a href="{{base_url('contents/materi/'.$result->file_name)}}" target="_blank">
         <div class="attachment-upload fileIn">
            <label>
                @if($result->file_type=="image/jpg" || $result->file_type=="image/jpeg" || $result->file_type=="image/png" || $result->file_type=="image/gif")
                    <i class=" icon-image2 text-warning  icon"></i>    
                @elseif($result->file_type=="application/pdf")
                    <i class="  icon-file-pdf text-danger  icon"></i>  
                @elseif($result->file_type=="application/vnd.openxmlformats-officedocument.wordprocessingml.document" || $result->file_type=="application/msword"   )
                    <i class="   icon-file-word text-primary  icon"></i>   
                @elseif($result->file_type=="application/vnd.openxmlformats-officedocument.presentationml.presentation"   )
                    <i class="    icon-file-text2 text-warning  icon"></i> 
                @elseif($result->file_type=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
                    <i class="     icon-file-excel text-success  icon"></i>    
                @elseif($result->file_type=="video/mp4" || $result->file_type=="video/x-matroska")
                    <i class=" icon-film4 text-pink  icon"></i>
                @else
                    <i class="      icon-file-empty text-default  icon"></i>   
                @endif
                <div class="gap-xs"></div>
                <span class="text-readmore name">{{$result->file_name}}</span>
                <span class="text-readmore size text-xs">{{number_format($result->size,0,',','.')}} Kb</span>
            </label>
        </div>
        </a>
     </div>
    @endforeach
    </div>
</div>
<div class="panel panel-body panel-flat">
    <form class="form-validate form-aksa-submit" action="{{$url_action}}" data-ckeditor data-type="redirect" method="POST" method="post" enctype="multipart/form-data">
        <input type="hidden" name="materi_id" value="{{$table->id}}">
    <div class="form-group">
        <textarea rows="4" placeholder="Ketik Komentar anda di sini ..." class="form-control" name="comment" required=""></textarea>
    </div>
    <div class="row">
        <div class="col-sm-4">
             <div class="media">
                <div class="media-left">
                    <a href="{{$table->lecturer->img_src->lg}}" data-popup="lightbox">
                        <img src="{{$table->lecturer->img_src->lg}}" style="width: 70px; height: 70px;" class="img-circle img-md" alt="">
                    </a>
                </div>

                <div class="media-body">
                    <h6 class="media-heading">{{$table->lecturer->name}}</h6>
                    <p class="text-muted">{{$table->lecturer->position}}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-8 text-right">
            <button type="submit" class="btn border-primary btn-xs text-primary btn-flat legitRipple">
                <i class=" icon-paperplane position-left"></i>
                Kirim Komentar
            </button>
        </div>
    </div>
</form> 
</div>
@foreach($table->comments as $result)
<div class="panel panel-body panel-flat">
    <div class="row">
        <div class="col-sm-4">
             <div class="media">
                <div class="media-left">
                    @if($result->role=="student")
                        <a href="{{$result->student->img_src->lg}}" data-popup="lightbox">
                            <img src="{{$result->student->img_src->lg}}" style="width: 70px; height: 70px;object-fit: cover;" class="img-circle img-md" alt="">
                        </a>
                    @else
                        <a href="{{$result->lecturer->img_src->lg}}" data-popup="lightbox">
                            <img src="{{$result->lecturer->img_src->lg}}" style="width: 70px; height: 70px;object-fit: cover;" class="img-circle img-md" alt="">
                        </a>
                    @endif
                </div>

                <div class="media-body">
                    @if($result->role=="student")
                    <h6 class="media-heading">{{$result->student->name}}</h6>
                    <p class="text-muted">Jurusan : {{$result->student->department}}</p>
                    @else
                    <h6 class="media-heading">{{$result->lecturer->name}}</h6>
                    <p class="text-muted">Jabatan : {{$result->lecturer->position}}</p>
                    @endif
                    
                </div>
            </div>
        </div>
        <div class="col-sm-8 text-right">
            <span class="text-sm text-light text-grey">Berkomentar Pada</span>
            <div class="gap-xs"></div>
            <span class="text-primary">
                {{tgl_indo($result->created_at)}}
            </span>
        </div>
    </div>
    <div class="gap-xs"></div>
    <article>
        {{$result->comment}}
    </article>
</div>
@endforeach

@endsection


@section('scripts')
	  @include("pieces.js.form")
@endsection