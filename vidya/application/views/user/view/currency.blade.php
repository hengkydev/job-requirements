@extends("user.template")

@section("title")
Currency
@endsection

@section("breadcrumbs")
<ul class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{base_url("user")}}">Beranda</a>
  </li>
  <li class="breadcrumb-item">
    <span>Currency</span>
  </li>
</ul>
@endsection

@section("content")
<div class="content-box">
    <div class="row">
      <div class="col-sm-12">
        <div class="element-wrapper">
          <h4 class="element-header">
            Currency
          </h4>
          <div class="element-content">
            <div class="element-box">
              <div class="table-responsive">
                <table id="response-table-hawk1" class="table table-striped table-bordered table-custom-me" data-url="{{base_url("user/api/currencies")}}" data-user="{{$__USER->id}}">
                  <thead>
                    <tr>
                      <th>
                        Pair
                      </th>
                      <th class="text-right">
                        Last
                      </th>
                      <th class="text-right">
                        Open
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
                        Chg. %
                      </th>
                      <th class="text-right">
                        Time
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td colspan="8" class="text-center text-sm">
                        <div class="gap-sm"></div>
                        <i class=" icon-spinner2 spinner text-primary position-left"></i>
                        Tunggu Sebentar, Sedang mengambil data ...
                      </td>
                    </tr>
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
<script type="text/javascript" src="{{base_url("mainassets/js/request/scrapper.js")}}"></script>
<script type="text/javascript">
  var scrapper   = new Scrapper;
  scrapper.init({},"currency")

  setInterval(function(){
      scrapper.init({},"currency")
    }, 3000 );
  
</script>
@endsection