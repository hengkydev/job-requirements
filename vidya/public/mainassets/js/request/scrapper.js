
class Scrapper {

  constructor(prepare) {

    this.url        = $("#response-table-hawk1").data("url");
    this.user       = $("#response-table-hawk1").data("user");
    this.api_key    = APP_API_KEY;
    this.config     = {
        url:this.url,
        method:"post",
        data:{},
        headers:{
          'Apikey': this.api_key
        }
    }
  }

  earningsCalendar(index,item){
    var html = "";
    if(typeof item.header !== 'undefined'){
      html +='<tr class="active"><td colspan="5" class="text-center">'+item.header+'</td></tr>';
    }else{
      var type = "'ec'";
      var data = "'"+item.id+"'";

      if(item.watchlist){
        var button = '<button class="btn-alert-remove" data-id="'+item.id+'" onclick="removeWatchlist('+data+','+type+')" title="Remove from Watch List"><i class="  icon-eye-blocked2"></i></button>';
      }else{
        var button = '<button class="btn-alert" data-id="'+item.id+'" onclick="addWatchlist('+data+','+type+')" title="Add To Watch List"><i class=" icon-eye2"></i></button>';
      }

      html += '<tr>'+
                  '<td>'+
                    '<img alt="" src="'+item.country.img.lg+'" class="position-left" width="25px"> '+item.company.name+
                    '&nbsp;&nbsp;(<span class="text-semibold text-primary">'+item.company.code+'</span>)'+
                  '</td>';


      if(item.eps_status=="plus"){
        html += '<td class="text-right"><span class="text-success text-semibold">'+item.eps+
        '</span>&nbsp;/&nbsp;'+item.eps_forecast+'</td>';
      }
      else if(item.eps_status=="minus"){
        html += '<td class="text-right"><span class="text-danger text-semibold">'+item.eps+
        '</span>&nbsp;/&nbsp;'+item.eps_forecast+'</td>';
      }else{
        html += '<td class="text-right"><span class="text-semibold">'+item.eps+
        '</span>&nbsp;/&nbsp;'+item.eps_forecast+'</td>';
      }

      if(item.revenue_status=="plus"){
        html += '<td class="text-right"><span class="text-success text-semibold">'+item.revenue+
        '</span>&nbsp;/&nbsp;'+item.revenue_forecast+'</td>';
      }
      else if(item.revenue_status=="minus"){
        html += '<td class="text-right"><span class="text-danger text-semibold">'+item.revenue+
        '</span>&nbsp;/&nbsp;'+item.revenue_forecast+'</td>';
      }else{
        html += '<td class="text-right"><span class="text-semibold">'+item.revenue+
        '</span>&nbsp;/&nbsp;'+item.revenue_forecast+'</td>';
      }
       
       html += '<td class="text-right">'+item.market_cap+'</td>';

       if(item.time=="before market open"){
          html += '<td class="text-right" title="'+item.time+'"><i class="wi wi-day-sunny text-warning"></i></td>'+
                  '</tr>';
       }else if(item.time=="after market open"){
          html += '<td class="text-right" title="'+item.time+'"><i class="wi wi-moon-alt-first-quarter text-grey"></i></td>'+
                  '</tr>';
       }else{
          html += '<td class="text-right" title="Tidak ada"></td>'+
                  '</tr>';   
       }
    }

    return html;
  }

  currency(index,item){
    var html = "";
    var data = "'"+item.id+"'";
    var arrow = "";

    if(item.pair.condition=="good"){
      arrow = '<i class="icon-arrow-up13 text-success position-left"></i>';
    }else if(item.pair.condition=="bad"){
      arrow = '<i class="icon-arrow-down132 text-danger position-left"></i>';
    }else{
       arrow = '<i class=" icon-arrow-right14 text-grey position-left"></i>';
    }

    if(item.chg_status=="up"){
      var chg   = '<span class="text-semibold text-success">'+item.chg+'</span>';
    }
    else if(item.chg_status=="down"){
      var chg   = '<span class="text-semibold text-danger">'+item.chg+'</span>';
    }else{
      var chg   = '<span class="text-semibold">'+item.chg+'</span>';
    }

    if(item.chg_percent_status=="up"){
      var chg_percent   = '<span class="text-semibold text-success">'+item.chg_percent+'</span>';
    }
    else if(item.chg_percent_status=="down"){
      var chg_percent   = '<span class="text-semibold text-danger">'+item.chg_percent+'</span>';
    }else{
      var chg_percent   = '<span class="text-semibold">'+item.chg_percent+'</span>';
    }

    html += '<tr>'+
                '<td>'+arrow+
                  '<span class="text-primary text-semibold">'+item.pair.name+'</span>'+
                '</td>'+
                '<td>'+item.last+'</td>'+
                '<td>'+item.open+'</td>'+
                '<td>'+item.high+'</td>'+
                '<td>'+item.low+'</td>'+
                '<td>'+chg+'</td>'+
                '<td>'+chg_percent+'</td>'+
                '<td>'+item.time+'</td>'+
              '</tr>';

    return html;
  }

  commodities(index,item){
    var html = "";
    if(item.chg_status=="up"){
      var chg   = '<span class="text-semibold text-success">'+item.chg+'</span>';
    }
    else if(item.chg_status=="down"){
      var chg   = '<span class="text-semibold text-danger">'+item.chg+'</span>';
    }else{
      var chg   = '<span class="text-semibold">'+item.chg+'</span>';
    }

    if(item.chg_percent_status=="up"){
      var chg_percent   = '<span class="text-semibold text-success">'+item.chg_percent+'</span>';
    }
    else if(item.chg_percent_status=="down"){
      var chg_percent   = '<span class="text-semibold text-danger">'+item.chg_percent+'</span>';
    }else{
      var chg_percent   = '<span class="text-semibold">'+item.chg_percent+'</span>';
    }

    if(item.time_status=="good"){
      var clock     = '<i class="position-right  icon-watch2 text-success"></i>';
    }else{
      var clock     = '<i class="position-right  icon-watch2 text-danger"></i>';
    }

    html += '<tr>'+
                '<td class="text-primary">'+
                  '<img alt="" src="'+item.flag.img.lg+'" class="position-left" width="25px"> '+item.commodity+
                '</td>'+
                '<td class="text-right">'+item.month+'</td>'+
                '<td class="text-right">'+item.last+'</td>'+
                '<td class="text-right">'+item.high+'</td>'+
                '<td class="text-right">'+item.low+'</td>'+
                '<td class="text-right">'+chg+'</td>'+
                '<td class="text-right">'+chg_percent+'</td>'+
                '<td class="text-right">'+item.time+' '+clock+'</td>'+
              '</tr>';

    return html;
  }

  globalIndex(index,item){
    var html  = "";
    var type = "'gi'";

      /*if(item.watchlist){
        var button = '<button class="btn-alert-remove" data-id="'+item.id+'" onclick="removeWatchlist('+item.id+','+type+')" title="Remove from Watch List"><i class="  icon-eye-blocked2"></i></button>';
      }else{
        var button = '<button class="btn-alert" data-id="'+item.id+'" onclick="addWatchlist('+item.id+','+type+')" title="Add To Watch List"><i class=" icon-eye2"></i></button>';
      }*/

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

    return html;
  }

  watchlist(index,item){
    var html ="";

      if((item.chg).includes("+")){
        var chg = '<span class="text-success text-semibold">'+item.chg+'</span>';
      }
      else if((item.chg).includes("-")){
        var chg = '<span class="text-danger text-semibold">'+item.chg+'</span>';
      }else{
        var chg = '<span class="text-semibold">'+item.chg+'</span>';
      }

      var notif_active = '';

      if(item.earning!=null){

        notif_active = (item.earning.notif.active) ? 'active' : '';

        var notif_html    = '<span class="notif-watchlist">'+
                            '<span class="pulsate-css"></span>'+
                            '<i class=" icon-primitive-dot"></i>'+
                          '</span>'+
                          '<span class="label">'+item.earning.notif.day_left+' days remain</span>';
      }else{
        var notif_html    = '<span class="notif-watchlist">'+
                              '<span class="pulsate-css"></span>'+
                              '<i class=" icon-primitive-dot"></i>'+
                            '</span>'+
                            '<span class="label">No Earning</span>';
      }

    html += '<div class="col-sm-4">'+
                '<div class="element-box pad-sm watchlists-item '+notif_active+'">'+
                 '<div class="row">'+
                    '<div class="col-sm-6">'+notif_html+
                    '</div>'+
                    '<div class="col-sm-6 text-right">'+
                        '<button class="btn-remove" data-id="'+item.id+'">'+
                          '<i class=" icon-trash position-left"></i> Remove'+
                        '</button>'+
                    '</div>'+
                 '</div>'+
                 '<div class="gap-xs"></div>'+
                 '<div class="text-center">'+
                    '<a href="#" title="'+item.name+'" class="text-readmore-3 text-grey">'+
                      '<img alt="" src="'+item.img.lg+'" class="position-left" width="25px">'+
                      '( <span class="text-semibold text-primary text-sm">'+item.symbol+'</span> )'+
                      '<span class="position-right">'+item.name+'</span>'+
                    '</a>'+
                 '</div>'+
                 '<div class="gap-xs"></div>'+
                 '<div class="border-icon">'+
                    '<span><i class=" icon-pulse2 position-left"></i> Stock Info</span>'+
                 '</div>'+
                 '<ul class="data-watchlists">'+
                   '<li>'+
                     '<span class="value">'+item.last+'</span>'+
                     '<span class="name">Last</span>'+
                   '</li>'+
                   '<li>'+
                     '<span class="value">'+item.high+'</span>'+
                     '<span class="name">High</span>'+
                   '</li>'+
                   '<li>'+
                     '<span class="value">'+chg+'</span>'+
                     '<span class="name">Chg</span>'+
                   '</li>'+
                    '<li>'+
                     '<span class="value">'+item.vol+'</span>'+
                     '<span class="name">Vol.</span>'+
                   '</li>'+
                 '</ul>'+
                 '</div>'+
                '</div>'+
              '</div>';

    return html;
  }

  stock(index,item){
    var html  = "";
    var type = "'stock'";

      if(item.watchlist){
        var button = '<button class="btn-alert-remove" data-id="'+item.id+'" onclick="removeWatchlist('+item.id+','+type+')" title="Remove from Watch List"><i class="  icon-eye-blocked2"></i></button>';
      }else{
        var button = '<button class="btn-alert" data-id="'+item.id+'" onclick="addWatchlist('+item.id+','+type+')" title="Add To Watch List"><i class=" icon-eye2"></i></button>';
      }

      html += '<tr>'+
                  '<td>'+button+
                    '<a href="#" title="'+item.name+'">'+
                    '<img alt="" src="'+item.img.lg+'" class="position-left" width="25px"> '+item.sort_name+
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
       html +=     '<td class="text-right">'+item.vol+'</td>';
       html +=     '<td class="text-right">'+item.time+' <i class=" icon-watch2 position-right text-pink"></i></td>'+
                  '</tr>';
          //console.log("Item - "+index,item.last);

    return html;
  }

  economiccalendar(index,item){
    var html = "";
     if(typeof item.header !== 'undefined'){
      html +='<tr class="active"><td colspan="7" class="text-center">'+item.header+'</td></tr>';
    }else{
      item.imp          = parseInt(item.imp);
      if(item.imp>0){
        var imp         = '<ul class="imp-list">';

        for (var i = 0; i < item.imp; i++) {
          imp           += '<li class="active"></li>';
        }

        for (i; i < 3; i++) {
          imp           += '<li></li>';
        }

        imp             += '</ul>';  
      }else{
        var imp         = '<span class="text-semibold">Holiday</span>';
      }

       if(item.actual_status=="up"){
          var actual   = '<span class="text-semibold text-success">'+item.actual+'</span>';
        }
        else if(item.actual_status=="down"){
          var actual   = '<span class="text-semibold text-danger">'+item.actual+'</span>';
        }else{
          var actual   = '<span class="text-semibold">'+item.actual+'</span>';
        }


       if(item.previous_status=="up"){
          var previous   = '<u class="text-success">'+item.previous+'</u>';
        }
        else if(item.previous_status=="down"){
          var previous   = '<u class="text-danger">'+item.previous+'</u>';
        }else{
          var previous   = '<u>'+item.previous+'</u>';
        }


      

      html += '<tr>'+
                  '<td>'+item.time+'</td>'+
                  '<td>'+
                    '<img alt="" src="'+item.currency.img.lg+'" class="position-left" width="25px">'+
                    '<span class="text-primary">'+item.currency.code+'</span>'+
                  '</td>'+
                  '<td>'+imp+'</td>'+
                  '<td>'+item.event+'</td>'+
                  '<td class="text-center">'+actual+'</td>'+
                  '<td class="text-center">'+item.forecast+'</td>'+
                  '<td class="text-center">'+previous+'</td>'+
                '</tr>';
    }

    return html;
  }

  init(data,type,element){

    element = (typeof element !== 'undefined') ? element : "#response-table-hawk1 tbody";

    var self = this;
    $.when(this.grabbing(data)).done(function(response){
      if (typeof response.message !== 'undefined') {
          self.showError(response.message);
      }else{
        var html  = "";

        if(type=="earningscalendar" || type=="economiccalendar"){
          var mydata = response.results.data;
        }else{
          var mydata = response.results;
        }

        $.each(mydata, function(index, item) {
          switch(type){
            case "earningscalendar" :
                html += self.earningsCalendar(index,item);
            break;
            case "globalindex":
                html += self.globalIndex(index,item);
            break;
            case "stock":
                html += self.stock(index,item);
            break;
            case "watchlist" :
                html += self.watchlist(index,item)
            break;
            case "currency":
                html += self.currency(index,item);
            break;
            case "commodities":
                html += self.commodities(index,item);
            break;
            case "economiccalendar":
                html += self.economiccalendar(index,item);
            break;
            default:
                console.log("scrapper log:","not Found");
          }
        });

          $(element).html(html);

      }
    });
    
  }


  grabbing (data){
    var url             = this.url;
    var user            = this.user;
    var api_key         = this.api_key;
    data.user_id        = user;
    this.config.data   = data
    //  console.log(this.config);

    return $.ajax(this.config);
  }
}


function addWatchlist(id){
  $.ajax({
    url:APP_URL+"user/watchlist/add",
    data:{
      id:id,
    },
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

    $(".datatable-hawk").find('button[data-id="'+id+'"]')
    .removeClass("btn-alert");
    $(".datatable-hawk").find('button[data-id="'+id+'"]')
    .addClass("btn-alert-remove");

    $(".datatable-hawk").find('button[data-id="'+id+'"]')
    .attr("onclick","removeWatchlist('"+id+"','ec')");

    $(".datatable-hawk").find('button[data-id="'+id+'"]')
    .attr("title","Remove from Watch List");

    $(".datatable-hawk").find('button[data-id="'+id+'"]')
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

 function removeWatchlist(id){
  $.ajax({
    url:APP_URL+"user/watchlist/remove",
    data:{id:id},
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

    $(".datatable-hawk").find('button[data-id="'+id+'"]')
    .removeClass("btn-alert-remove");
    $(".datatable-hawk tbody").find('button[data-id="'+id+'"]')
    .addClass("btn-alert");

    $(".datatable-hawk").find('button[data-id="'+id+'"]')
    .attr("onclick","addWatchlist('"+id+"','ec')");

    $(".datatable-hawk").find('button[data-id="'+id+'"]')
    .attr("title","Add to Watch List");

    $(".datatable-hawk").find('button[data-id="'+id+'"]')
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
  
  /*setInterval(function(){
    
  }, 3000);*/