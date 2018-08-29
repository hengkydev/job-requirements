@extends("user.template")

@section("title")
Earnings Calendar
@endsection

@section("breadcrumbs")
<ul class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{base_url("user")}}">Beranda</a>
  </li>
  <li class="breadcrumb-item">
    <span>Earnings Calendar</span>
  </li>
</ul>
@endsection

@section("content")
<div class="content-box">
    <div class="row">
      <div class="col-sm-12">
        <div class="element-wrapper">
          <h4 class="element-header">
            Earnings Calendar
          </h4>
          <div class="element-content">
            <div class="element-box">
              <div class="row">
                <div class="col-sm-3">
                 <button class="btn-main-hawk" data-toggle="modal" data-target=".bd-example-modal-lg" type="button"> 
                 <i class=" icon-filter3 position-left"></i>   Filter
                 </button>
                </div>
                <div class="col-sm-9 text-right">
                    <ul class="sort-button-hawk">
                    <li>
                      <button>Yesterday</button>
                    </li>
                    <li  class="active">
                      <button>Today</button>
                    </li>
                    <li>
                      <button>Tommorow</button>
                    </li>
                    <li>
                      <button>This Week</button>
                    </li>
                    <li>
                      <button>Next Week</button>
                    </li>
                    <li>
                      <button><i class=" icon-calendar22 position-left"></i> Choose Date</button>
                    </li>
                  </ul>
                </div>
                
              </div>
              <div class="gap-md"></div>
              <div class="table-responsive">
                <table id="response-table-hawk1" class="table table-striped table-bordered table-custom-me" data-url="{{base_url("user/api/earningscalendar")}}" data-user="{{$__USER->id}}">
                  <thead>
                    <tr>
                      <th>
                        Company
                      </th>
                      <th class="text-right">
                        Eps / <span class="no-bold">Forecast</span>
                      </th>
                      <th class="text-right">
                        Revenue / <span class="no-bold">Forecast</span>
                      </th>
                      <th class="text-right">
                        Market Cap
                      </th>
                      <th class="text-right">
                        Time
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td colspan="5" class="text-center text-sm">
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

@section("footer")
<div aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="exampleModalLabel">
          <i class=" icon-filter3 position-left text-white"></i> Filter Option
        </h5>
        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true" class="text-white"> &times;</span></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="gap-sm"></div>
          <ul class="nav nav-tabs sort-button-hawk">
            <li class="active">
              <a data-toggle="tab" href="#option-country">
                <i class=" icon-flag3 position-left"></i> Select Country
              </a>
            </li>
            <li>
              <a data-toggle="tab" href="#option-sector">
                <i class=" icon-tree5 position-left"></i> Select Sector
              </a>
            </li>
            <li>
              <a data-toggle="tab" href="#option-importance">
                <i class=" icon-exclamation position-left"></i> Select Importance
              </a>
            </li>
          </ul>
          <div class="gap-md"></div>
          <div class="tab-content">
            <div id="option-country" class="tab-pane fade in active">
              <div class="row">
                <div class="col-sm-6">
                  <div class="input-search-hawk " >
                    <input type="search" name="q" class="find-item-list" data-item=".item-country-list"  placeholder="Find Country ...">
                    <button type="button" class="icon"><i class=" icon-search4"></i></button>
                  </div>
                </div>
                <div class="col-sm-5 text-right">
                  <div class="gap-xs"></div>
                  <label class="checkbox-inline">
                      <input type="checkbox" class="control-primary">
                      <span class="position-right">Select All Country</span>
                    </label>
                </div>
              </div>
              <div class="gap-sm"></div>
              <div class="tab-content-maxheight-modal">
                <div class="row item-country-container">
                  @foreach($countries as $result)
                  <div class="col-sm-3 item-country-list"  data-name="{{$result->name}}">
                    <label title="{{$result->name}}" class="checkbox-country ">
                      <img src="{{$result->img_src->lg}}">
                      <input type="checkbox" name="countries[]" value="{{$result->value}}"  class="hidden">
                      {{$result->name}}
                    </label>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
            <div id="option-sector" class="tab-pane fade">
              <div class="row">
                @foreach($sector as $result)
                <div class="col-sm-4">
                   <label class="checkbox-inline">
                    <input type="checkbox" name="sector[]" class="control-primary" value="{{$result->value}}">
                    <span class="position-right">{{$result->name}}</span>
                  </label>
                </div>
                @endforeach
              </div>
            </div>
            <div id="option-importance" class="tab-pane fade">
              <div class="row">
                <div class="col-sm-4">
                   <label class="checkbox-inline ">
                    <input type="checkbox" name="Importance[]" class="control-primary" value="1">
                    <ul class="imp-list equal-uniform-checkbox"><li class="active"></li><li></li><li></li></ul>
                  </label>
                </div>
                <div class="col-sm-4">
                   <label class="checkbox-inline">
                    <input type="checkbox" name="Importance[]" class="control-primary" value="2">
                    <ul class="imp-list equal-uniform-checkbox"><li class="active"></li><li class="active"></li><li></li></ul>
                  </label>
                </div>
                <div class="col-sm-4">
                   <label class="checkbox-inline">
                    <input type="checkbox" name="Importance[]" class="control-primary" value="3">
                    <ul class="imp-list equal-uniform-checkbox"><li class="active"></li><li class="active"></li><li class="active"></li></ul>
                  </label>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal" type="button"> Close</button><button class="btn btn-primary" type="button"> Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section("scripts")
<script type="text/javascript" src="{{base_url('panelassets/js/plugins/forms/styling/uniform.min.js')}}"></script>
<script type="text/javascript" src="{{base_url("mainassets/js/request/scrapper.js")}}"></script>
<script type="text/javascript">

 $(".control-primary").uniform({
    radioClass: 'choice',
    wrapperClass: 'border-primary-600 text-primary-800'
});
  var scrapper   = new Scrapper;
  scrapper.init({
         'currentTab':'today',
      },"earningscalendar")

    

      $(".find-item-list").keyup(function(event){
          var str         = ($(this).val()).toLowerCase();
          var item_list   = $(this).data("item");
          $(item_list).each(function(index,item) {
            var item_name   = ($(this).attr("data-name")).toLowerCase();
            if((item_name).indexOf(str) <= -1){
              $(this).hide();
            }else{
              $(this).show();
            }
          });
      })  
    

/*  setInterval(function(){
      scrapper.init({
         'dateFrom':'2018-06-1',
          'dateTo':'2018-06-10',
      },"earningscalendar")
    }, 5000 );
  */
</script>
@endsection