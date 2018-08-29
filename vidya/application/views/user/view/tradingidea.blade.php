@extends("user.template")

@section("breadcrumbs")
<ul class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{base_url("user")}}">Beranda</a>
  </li>
  <li class="breadcrumb-item">
    <span>Trading Idea</span>
  </li>
</ul>
@endsection

@section("content")
 <div class="content-box">
    <div class="row">
      <div class="col-sm-12">
        <div class="element-wrapper">
         <h4 class="element-header">
            Daftar Trading Idea
          </h4>
          <div class="element-content">
            <div class="element-box">
              <div class="row">
                <div class="col-sm-5">
                  <div class="help-block">
                    <i class=" icon-exclamation position-left text-warning"></i> 
                    Daftar <span class="text-semibold">Trading Idea</span> Berdasarkan levelnya
                  </div>
                </div>
              </div>
              <div class="gap-md"></div>
              <div class="table-responsive datatable-hawk">
                <table  class="datatable-basic table table-striped table-bordered table-custom-me" >
                  <thead>
                    <tr>
                      <th width="50">
                        Power
                      </th>
                      <th width="100">
                        Symbol
                      </th>
                      <th>
                        Remark
                      </th>
                      <th class="text-right" width="100">
                        Date
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($table as $result)
                    <tr>
                        <td class="{{colorHawk1($result->power)}}">
                            {{$result->power}}
                        </td>
                        <td >
                          <span class="text-semibold text-primary">{{$result->symbol}}</span>
                        </td>
                        <td  class="text-sm">
                            {{$result->remark}}
                        </td>
                        <td >{{tgl_indo($result->datetime)}}</td>
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
@endsection