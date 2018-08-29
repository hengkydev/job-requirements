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
            Daftar Stocks
          </h4>
          <div class="element-content">
            <div class="element-box">
              <div class="row">
                <div class="col-sm-5">
                  <b>
                    <i class=" icon-exclamation position-left text-warning"></i> 
                    United States All Stocks
                  </b>
                  <div class="help-block text-sm text-grey">
                    Menampilkan semua data Stock untuk Negara <b>Amerika Serikat</b>
                  </div>
                </div>
                <div class="col-sm-7 text-right">
                  <ul class="sort-button-hawk">
                    <li class="active">
                      <button >
                        <i class=" icon-coin-dollar position-left"></i>
                        Price
                      </button>
                    </li>
                    <li>
                      <button>
                        <i class=" icon-meter-fast position-left"></i>
                        Performance
                      </button>
                    </li>
                    <li>
                      <button>
                        <i class=" icon-cog position-left"></i>
                        Technical
                      </button>
                    </li>
                    <li>
                      <button>
                      <i class=" icon-stack2 position-left"></i>
                      Fundamental
                    </button>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="gap-md"></div>
              <div class="table-responsive datatable-hawk">
                <table  class="datatable-basic table table-striped table-bordered table-custom-me" >
                  <thead>
                    <tr>
                      <th>
                        Name
                      </th>
                      <th class="text-right">
                        Last
                      </th>
                      <th class="text-right">
                        High
                      </th>
                      <th class="text-right">
                        Low
                      </th>
                      <th class="text-right">
                        Chg
                      </th>
                      <th class="text-right">
                        Chg.%
                      </th>
                      <th class="text-right">
                        Vol.
                      </th>
                      <th class="text-right" width="120">
                        Time
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($stocks as $item)
                    <tr>
                        <td width="200" title="{{$item->name}}">
                          <span class="text-readmore-3">
                          @if(in_array($item->unique, $watchlists))
                            <button class="btn-alert-remove" data-id="{{$item->id}}" onclick="removeWatchlist({{$item->id}})" title="Remove from Watch List">
                              <i class="  icon-eye-blocked2"></i>
                            </button>
                          @else
                            <button class="btn-alert" data-id="{{$item->id}}" onclick="addWatchlist({{$item->id}})" title="Add To Watch List">
                              <i class=" icon-eye2"></i>
                            </button>
                          @endif
                          <a href="#" title="{{$item->name}}" >
                            <img alt="" src="{{$item->img_src->lg}}" class="position-left" width="25px"> {{$item->sort_name}}
                          </a>
                          </span>
                        </td>
                        <td class="text-right">{{$item->last}}</td>
                        <td class="text-right">{{$item->high}}</td>
                        <td class="text-right">{{$item->low}}</td>
                        @if(strpos($item->chg, "+") !== false)
                          <td class="text-right text-success text-semibold">{{$item->chg}}</td>
                        @elseif(strpos($item->chg, "-") !== false)
                          <td class="text-right text-danger text-semibold">{{$item->chg}}</td>
                        @else
                          <td class="text-right text-semibold">{{$item->chg}}</td>
                        @endif

                        @if(strpos($item->chg_percent, "+") !== false)
                          <td class="text-right text-success text-semibold">{{$item->chg_percent}}</td>
                        @elseif(strpos($item->chg_percent, "-") !== false)
                          <td class="text-right text-danger text-semibold">{{$item->chg_percent}}</td>
                        @else
                          <td class="text-right text-semibold">{{$item->chg_percent}}</td>
                        @endif
                        <td class="text-right">{{$item->vol}}</td>
                        <td class="text-right">{{$item->time}} <i class=" icon-watch2 position-right text-pink"></i></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section("scripts")
@include("pieces.js.datatable")
<script type="text/javascript" src="{{base_url("mainassets/js/request/scrapper.js")}}"></script>
@endsection