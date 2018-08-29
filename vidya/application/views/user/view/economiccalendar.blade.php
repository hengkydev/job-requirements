@extends("user.template")

@section("title")
Economic Calendar
@endsection

@section("breadcrumbs")
<ul class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{base_url("user")}}">Beranda</a>
  </li>
  <li class="breadcrumb-item">
    <span>Economic Calendar</span>
  </li>
</ul>
@endsection

@section("content")
<div class="content-box">
    <div class="row">
      <div class="col-sm-12">
        <div class="element-wrapper">
          <h4 class="element-header">
            Economic Calendar
          </h4>
          <div class="element-content">
            <div class="element-box">
              <div class="row">
                <div class="col-sm-9">
                  <ul class="filter-option">
                    <li>Yesterday</li>
                    <li class="active">Today</li>
                    <li>Tommorow</li>
                    <li>This Week</li>
                    <li>Next Week</li>
                    <li>
                      <i class=" icon-calendar22 position-left"></i> Choose Date
                    </li>
                  </ul>
                </div>
                <div class="col-sm-3 text-right">
                 <button class="mr-2 mb-2 btn btn-success btn-sm" type="button"> 
                 <i class=" icon-filter3 position-left"></i>   Filter
                 </button>
                </div>
              </div>
              <div class="gap-sm"></div>
              <div class="table-responsive">
                <table id="response-table-hawk1" class="table table-striped table-bordered table-custom-me" data-url="{{base_url("user/api/economiccalendar")}}" data-user="{{$__USER->id}}">
                  <thead>
                    <tr>
                      <th width="100">
                        Time
                      </th>
                      <th>
                        Cur.
                      </th>
                      <th width="150">
                        Imp.
                      </th>
                      <th>
                        Event
                      </th>
                      <th class="text-center">
                        Actual
                      </th>
                      <th class="text-center">
                        Forecast
                      </th>
                      <th class="text-center">
                        Previous
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td colspan="7" class="text-center text-sm">
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
  scrapper.init({
         'currentTab':'today',
      },"economiccalendar")

 /* setInterval(function(){
      scrapper.init({
         'currentTab':'today',
      },"economiccalendar")
    }, 5000 );*/
  
</script>
@endsection