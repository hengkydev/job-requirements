@extends("user.template")

@section("breadcrumbs")
<ul class="breadcrumb">
	<li class="breadcrumb-item">
	  <a href="{{base_url("user")}}">Beranda</a>
	</li>
	<li class="breadcrumb-item">
	  <span>Global Index</span>
	</li>
</ul>
@endsection

@section("content")
 <div class="content-box">
         <div class="element-wrapper">
  <div class="element-box">
    <h5 class="form-header">
      Global Index
    </h5>
    <div class="form-desc">YLorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi malesuada blandit nisl, id laoreet augue tempor aliquet. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. 
    </div>
    <div class="table-responsive">
      <table id="response-table-hawk1" class="table table-striped table-bordered table-custom-me" data-url="{{base_url("user/api/globalindex")}}" data-user="{{$__USER->id}}">
        <thead>
          <tr>
            <th>
              Index
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
              Time
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
@endsection

@section("scripts")
<script type="text/javascript">
  function addWatchlist(id,type){
    $.ajax({
      url:APP_URL+"user/watchlist/add",
      data:{id:id,type:type},
      method:"post",
      beforeSend:function(){
        loadingMessage("adding to watchlist ..");
      }
    }).done(function(response){
      $.unblockUI();
      sweetAlert({
            title:'Ok, Berhasil!',
            text:response.results,
            type:"success",
        });

      $("#response-table-hawk1 tbody").find('button[data-id="'+id+'"]')
      .removeClass("btn-alert");
      $("#response-table-hawk1 tbody").find('button[data-id="'+id+'"]')
      .addClass("btn-alert-remove");

      $("#response-table-hawk1 tbody").find('button[data-id="'+id+'"]')
      .attr("onclick","removeWatchlist("+id+",'gi')");

      $("#response-table-hawk1 tbody").find('button[data-id="'+id+'"]')
      .attr("title","Remove from Watch List");

      $("#response-table-hawk1 tbody").find('button[data-id="'+id+'"]')
      .html('<i class="icon-eye-blocked2"></i>');

    }).fail(function(response){
      $.unblockUI();
      var response = response.responseJSON;
       sweetAlert({
            title:'Opps!',
            text:response.message,
            type:"error",
        });
    })
  }

   function removeWatchlist(id,type){
    $.ajax({
      url:APP_URL+"user/watchlist/remove",
      data:{id:id,type:type},
      method:"post",
      beforeSend:function(){
        loadingMessage("removing from watchlist ..");
      }
    }).done(function(response){
      $.unblockUI();
      sweetAlert({
            title:'Ok, Berhasil!',
            text:response.results,
            type:"success",
        });

      $("#response-table-hawk1 tbody").find('button[data-id="'+id+'"]')
      .removeClass("btn-alert-remove");
      $("#response-table-hawk1 tbody").find('button[data-id="'+id+'"]')
      .addClass("btn-alert");

      $("#response-table-hawk1 tbody").find('button[data-id="'+id+'"]')
      .attr("onclick","addWatchlist("+id+",'gi')");

      $("#response-table-hawk1 tbody").find('button[data-id="'+id+'"]')
      .attr("title","Add to Watch List");

      $("#response-table-hawk1 tbody").find('button[data-id="'+id+'"]')
      .html('<i class="icon-eye2"></i>');

    }).fail(function(response){
      $.unblockUI();
      var response = response.responseJSON;
       sweetAlert({
            title:'Opps!',
            text:response.message,
            type:"error",
        });
    })
  }

  function getRequest(){
    var url     = $("#response-table-hawk1").data("url");
    var user    = $("#response-table-hawk1").data("user");
    $.ajax({
      url:url,
      data:{user_id:user},
      method:"post",
      headers: { 'Apikey': 'key-20180325105323-qhahdxuwag45vdu7d5fkrdnwsetm58vb' }
    }).done(function(response){
       var html  = "";
       jQuery.each(response.results, function(index, item) {
        var type = "'gi'";

        if(item.watchlist){
          var button = '<button class="btn-alert-remove" data-id="'+item.id+'" onclick="removeWatchlist('+item.id+','+type+')" title="Remove from Watch List"><i class="  icon-eye-blocked2"></i></button>';
        }else{
          var button = '<button class="btn-alert" data-id="'+item.id+'" onclick="addWatchlist('+item.id+','+type+')" title="Add To Watch List"><i class=" icon-eye2"></i></button>';
        }

        html += '<tr>'+
                    '<td>'+
                      '<a href="#">'+
                      '<img alt="" src="'+item.index.img.lg+'" class="position-left" width="25px"> '+item.index.name+
                      '</a>'+
                    '</td>'+
                    '<td class="text-right">'+item.last+'</td>'+
                    '<td class="text-right">'+item.high+'</td>'+
                    '<td class="text-right">'+item.low+'</td>';


        if((item.chg).includes("+")){
          html += '<td class="text-right text-success text-semibold">'+item.chg+'</td>';
        }
        else if((item.chg).includes("-")){
          html += '<td class="text-right text-danger  text-semibold">'+item.chg+'</td>';
        }else{
          html += '<td class="text-right">'+item.chg+'</td>';
        }

        if((item.chg_percent).includes("+")){
          html += '<td class="text-right text-success text-semibold">'+item.chg_percent+'</td>';
        }
        else if((item.chg_percent).includes("-")){
          html += '<td class="text-right text-danger  text-semibold">'+item.chg_percent+'</td>';
        }else{
          html += '<td class="text-right">'+item.chg_percent+'</td>';
        }
         
         html +=     '<td class="text-right">'+item.time+' <i class=" icon-watch2 position-right text-pink"></i></td>'+
                    '</tr>';
            //console.log("Item - "+index,item.last);
        });

      $("#response-table-hawk1 tbody").html(html);
    }).fail(function(response){
      console.log(response);
    })
  }

  getRequest();

  setInterval(function(){
    getRequest();
    
  }, 5000 );
  
  /*setInterval(function(){
    
  }, 3000);*/

</script>

@endsection

@section("scriptsss")
<script type="text/javascript" src="{{base_url("socket/socket.io.js")}}"></script>
<script>
  var socket = io('http://localhost:3000');
  socket.on('connect', function(){
    console.log('a user connected');
  });

  socket.emit("global_index_start","{{$__USER->id}}");

  socket.on('chat message', function(msg){
    console.log('message: ' + msg);
  });

  socket.on('global_index', function(response){
    //console.log('global_index: ' + response.results);

    var html  = "";

    jQuery.each(response.results, function(index, item) {
      html += '<tr>'+
                  '<td>'+
                    '<button class="btn-alert" title="Add To Watch List"><i class=" icon-eye2"></i></button>'+
                    '<a href="#">'+
                    '<img alt="" src="'+item.index.img.lg+'" class="position-left" width="25px"> '+item.index.name+
                    '</a>'+
                  '</td>'+
                  '<td class="text-right">'+item.last+'</td>'+
                  '<td class="text-right">'+item.high+'</td>'+
                  '<td class="text-right">'+item.low+'</td>';

    if((item.chg).includes("+")){
      html += '<td class="text-right text-success text-semibold">'+item.chg+'</td>';
    }
    else if((item.chg).includes("-")){
      html += '<td class="text-right text-danger  text-semibold">'+item.chg+'</td>';
    }else{
      html += '<td class="text-right">'+item.chg+'</td>';
    }

    if((item.chg_percent).includes("+")){
      html += '<td class="text-right text-success text-semibold">'+item.chg_percent+'</td>';
    }
    else if((item.chg_percent).includes("-")){
      html += '<td class="text-right text-danger  text-semibold">'+item.chg_percent+'</td>';
    }else{
      html += '<td class="text-right">'+item.chg_percent+'</td>';
    }
     
     html +=     '<td class="text-right">'+item.time+' <i class=" icon-watch2 position-right text-pink"></i></td>'+
                '</tr>';
        //console.log("Item - "+index,item.last);
    });

    $("#response-table-hawk1 tbody").html(html);
  });
  socket.on('event', function(data){
    console.log('a user connected 3');
  });
  socket.on('disconnect', function(){
    console.log('a user connected 2');
  });
</script>
@endsection