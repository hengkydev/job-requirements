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
         <h4 class="element-header">
            Daftar Watchlist
          </h4>
          <div class="element-content">
            <div class="row" id="response-table-hawk1" data-url="{{base_url("user/api/watchlists")}}" data-user="{{$__USER->id}}">
              @foreach($watchlists as $result)
              <div class="col-sm-4">
                @if($result->notif)
                  @if($result->notif->day_left>0)
                    <div class="element-box pad-sm watchlists-item active">
                  @else
                    <div class="element-box pad-sm watchlists-item">
                  @endif
                @else
                  <div class="element-box pad-sm watchlists-item">
                @endif
                   <div class="row">
                      <div class="col-sm-6 ">
                        @if($result->notif)
                        @if($result->notif->day_left>0)
                         <span class="notif-watchlist">
                            <span class="pulsate-css"></span>
                            <i class=" icon-primitive-dot"></i>
                          </span>
                          <span class="label">{{$result->notif->day_left}} days remain</span>
                        @else
                         <span class="notif-watchlist">
                            <span class="pulsate-css"></span>
                            <i class=" icon-primitive-dot"></i>
                          </span>
                          <span class="label">No Earning</span>
                        @endif
                        @else
                        <span class="notif-watchlist">
                            <span class="pulsate-css"></span>
                            <i class=" icon-primitive-dot"></i>
                          </span>
                          <span class="label">No Earning</span>
                        @endif
                      </div>
                      <div class="col-sm-6 text-right">
                          <button class="btn-remove" data-id="{{$result->id}}">
                            <i class=" icon-trash position-left"></i> Remove'
                          </button>
                      </div>
                   </div>
                   <div class="gap-xs"></div>
                   <div class="text-center">
                      <a href="#" title="{{$result->stock->name}}" class="text-readmore-3 text-grey">
                        <img alt="" src="{{$result->stock->img_src->lg}}" class="position-left" width="25px">
                        ( <span class="text-semibold text-primary text-sm">{{$result->stock->symbol}}</span> )
                        <span class="position-right">{{$result->stock->name}}</span>
                      </a>
                   </div>
                   <div class="gap-sm"></div>
                   <div class="border-icon">
                      <span><i class=" icon-pulse2 position-left"></i> Stock Info</span>
                   </div>
                   <ul class="data-watchlists">
                     <li>
                       <span class="value">{{$result->stock->last}}</span>
                       <span class="name">Last</span>
                     </li>
                     <li>
                       <span class="value">{{$result->stock->high}}</span>
                       <span class="name">High</span>
                     </li>
                     <li>
                       @if(strpos($result->stock->chg, "+") !== false)
                        <span class="value text-semibold text-success">{{$result->stock->chg}}</span>
                       @elseif(strpos($result->stock->chg, "-") !== false)
                        <span class="value text-semibold text-danger">{{$result->stock->chg}}</span>
                       @else
                        <span class="value">{{$result->stock->chg}}</span>
                       @endif
                       <span class="name">Chg</span>
                     </li>
                      <li>
                       <span class="value">{{$result->stock->vol}}</span>
                       <span class="name">Vol.</span>
                     </li>
                   </ul>
                 </div>
              </div>
              @endforeach
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section("scriptsss")
<script type="text/javascript" src="{{base_url("mainassets/js/request/scrapper.js")}}"></script>
<script type="text/javascript">
  var scrapper   = new Scrapper;
  scrapper.init({
    currentTab:"today"
  },"watchlist","#response-table-hawk1");
</script>
@endsection