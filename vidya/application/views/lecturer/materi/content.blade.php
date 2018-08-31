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
  <form class="form-validate form-aksa-submit" action="{{$url_action}}" data-ckeditor data-type="redirect" method="POST" method="post" enctype="multipart/form-data">
@if($type=="update")
<input type="hidden" name="id" value="{{$table->id}}">
@endif
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-flat">
            <div class="panel-body">
                <div class="form-group">
                    <label><b class="text-danger position-left">*</b>Nama Materi : </label>
                    <input type="text" name="name" value="{{@$table->name}}" class="form-control" placeholder="Ketikan Nama Materi di sini ..." required="">
                </div>
                <div class="form-group">
                    <label>Isi Deskripsi Materi : </label>
                    <textarea id="editor-full" class="form-control" name="description">{!! @$table->description !!}</textarea>
                </div>
                <div class="form-group">
                    <label class="display-block"><i class=" icon-attachment position-left text-warning"></i>Sisipkan File Materi </label>
                    <div class="help-block text-light">
                        File Materi yang di perbolehkan berformat extensi 
                        <span class="text-primary">jpg, png, jpeg, mp4, mkv, avi, docx, doc, xls, xlsx, ppt, pptx, pdf</span><br>
                        dengan maksimal ukuran file <span class="text-danger">50 MB</span>
                    </div>
                    <div class="row">
                        <div class="col-xs-2">
                            <div class="attachment-upload-plus">
                                <i class=" icon-plus-circle2"></i>
                                Tambah File
                            </div>
                        </div>
                        @if($type=="create")
                        <div class="col-xs-2">
                            <div class="attachment-upload">
                                <label>
                                    <i class="icon-file-upload icon"></i>
                                    <div class="gap-xs"></div>
                                    <span class="text-readmore name">Upload File</span>
                                    <span class="text-readmore size text-xs"></span>
                                    <input type="file" name="attachment[]" class="attachment-upload-input" accept="*">
                                    
                                </label>
                                <span class="close" title="Hapus file sisipan">
                                        <i class=" icon-cross3"></i>
                                    </span>
                            </div>
                        </div>
                        @else
                        @foreach($table->attachments as $result)
                        <div class="col-xs-2">
                            <div class="attachment-upload">
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
                                    <input type="hidden" name="attachment_valid_{{$result->id}}" value="{{$result->id}}">
                                    <div class="gap-xs"></div>
                                    <span class="text-readmore name">{{$result->file_name}}</span>
                                    <span class="text-readmore size text-xs">{{number_format($result->size,0,',','.')}} Kb</span>
                                    <input type="file" name="attachment_{{$result->id}}" class="attachment-upload-input" accept="*">
                                    
                                </label>
                                <span class="close" title="Hapus file sisipan">
                                        <i class=" icon-cross3"></i>
                                    </span>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        
                    </div>
                </div>
                <div class="form-group">
                    <label><i class=" icon-image5 position-left text-primary"></i> Fitur Gambar :</label>
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
                            <span class="help-block no-margin text-sm">Format : png, jpg. Maks 5Mb</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label><i class=" icon-exclamation position-left text-warning"></i>Status Materi : </label>
                    <div class="checkbox checkbox-switch">
                        <label>
                            @if($type=="create")
                            <input type="checkbox" class="switch" name="status" data-on-text="Publish" data-off-text="Draft" name="status" checked="checked">
                            @else
                            <input type="checkbox" class="switch" name="status" data-on-text="Publish" data-off-text="Draft" name="status" {{match($table->status,"publish","checked")}}>
                            @endif
                        </label>
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
    <script type="text/javascript" src="{{base_url('mainassets/js/form/materi.js')}}"></script>
  @include("pieces.js.form")

@endsection