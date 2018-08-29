

$('.daterange-single').daterangepicker({ 
    singleDatePicker: true,
     locale: {
      format: 'YYYY-MM-DD'
    },
    autoUpdateInput:false,
    formatSubmit: 'YYYY-MM-DD'
}, function(chosen_date) {
  this.element.val(chosen_date.format('YYYY-MM-DD'));
});

 

$('.daterange-single-time').daterangepicker({ 
    timePicker: true,
    singleDatePicker: true,
     locale: {
      format: 'YYYY-MM-DD'
    },
    autoUpdateInput:false,
    formatSubmit: 'YYYY-MM-DD H:mm'
}, function(chosen_date) {
  this.element.val(chosen_date.format('YYYY-MM-DD H:mm'));
});
 // Initialize with options
    $('.daterange-ranges').daterangepicker(
        {
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            minDate: '01/01/2012',
            maxDate: '12/31/2016',
            dateLimit: { days: 60 },
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            opens: 'left',
            applyClass: 'btn-small bg-slate-600',
            cancelClass: 'btn-small btn-default'
        },
        function(start, end) {
            $('.daterange-ranges span').html(start.format('MMMM D, YYYY') + ' &nbsp; - &nbsp; ' + end.format('MMMM D, YYYY'));
        }
    );

    // Display date format
    $('.daterange-ranges span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' &nbsp; - &nbsp; ' + moment().format('MMMM D, YYYY'));


$(".xhr-input").change(function(){
    var value       = $(this).val();
    var exception   = $(this).data('exception');
    var parents     = $(this).parents(".form-group");
    var icon        = $(parents).find(".form-control-feedback i");
    var helpblock   = $(parents).find(".help-block");

    if(value=="" || value==false){
        $(parents).attr("class","form-group has-feedback");
        $(icon).attr("class","icon-notification2");
        $(helpblock).html("");
        return;
    }

    var params  = {
        value:value,
        exception:exception
    }

    var ldMessage       = "Sedang memproses ...";

    $.ajax({

        url:$(this).data('url'),
        data:params,
        method:"post",
        beforeSend:function(){
            $(parents).attr("class","form-group has-feedback");
            $(icon).attr("class","icon-spinner2 spinner");
            $(helpblock).html("");
        }

    }).done(function(response){
        $(parents).addClass("has-success");
        $(icon).attr("class","icon-check");
        $(helpblock).html("");
        $.unblockUI();
    }).fail(function(response){
        $.unblockUI();
        var response = response.responseJSON;
        $(parents).addClass("has-error");
        $(icon).attr("class","icon-cancel-circle2");
        $(helpblock).html(response.message);
        $.unblockUI();
    })


})

$(".styled").uniform({radioClass: 'choice'});

$(".switch").bootstrapSwitch();

$('.select2').select2({placeholder: "Select a Something"});


$(function() {

    if($("#editor-full").length>0){
        CKEDITOR.replace( 'editor-full', {
            height: '262px',
        });
        
        CKEDITOR.disableAutoInline = true;    
    }

    if($("#editor-small").length>0){
        CKEDITOR.replace( 'editor-small', {
            height: '180px',
            toolbarGroups: [
                {"name":"basicstyles","groups":["basicstyles"]},
                {"name":"links","groups":["links"]},
                {"name":"paragraph","groups":["list","blocks"]},
                {"name":"insert","groups":["insert"]},
                {"name":"styles","groups":["styles"]},
                { name: 'tools', "groups": [ 'Maximize'] }
            ],
        });
        
        CKEDITOR.disableAutoInline = true;    
    }
});



 function grecaptchaSubmit(){
    $(".form-aksa-submit").submit();
 }
 

 function formNotifResponse(type,response){
     type                    = (typeof type !== 'undefined') ? type : 'alert';
     var message            = (typeof response.message !== 'undefined') ? response.message : "Tidak ada pesan ...";

     if (typeof message === 'string' || message instanceof String){
        message                = (message=="") ? "Tidak ada pesan ..." : message;
     }else{
        message                 = "Tidak ada pesan ...";
     }
     
     var redirect           = (typeof response.results !== 'undefined') ? response.results : document.referrer;
     var status             = (typeof response.status !== 'undefined') ? response.status : false;

     if(typeof response.errors !== "undefined"){
        message             = response.errors[Object.keys(response.errors)[0]][0];
     }

    if(type=="notif"){

         if(status){

            ShowNotif({type:"success",message:"<i class='icon-spinner2 spinner position-left'></i> Mengalihkan halaman ... "})
            setTimeout(function(){
                window.location.href = redirect;
            },2000);
            return;

        }else{

            if(typeof grecaptcha !== 'undefined'){
                grecaptcha.reset();
            }

            ShowNotif({type:"error",message:message});

            return;
        }

    }else if(type=="alert") {

        if(status){

            sweetAlert({
                title:'Ok, Berhasil!',
                text:message,
                type:"success",
            },function(){
                window.location.href = document.referrer;
            });

            return;

        }else{
            sweetAlert({
                title:'Maaf ada kesalahan!',
                text:message,
                type:"error",
            });    

            return;
        }
        
    }else{

        if(status){
            window.location.href = redirect;
        }else{
            sweetAlert({
                title:'Opps!',
                text:message,
                type:"error",
            });
        }

    }
   
 }

 if($(".form-aksa-submit[data-socket]").length>0){
    var socket       = io(APP_SOCKET);
 }


 $(".form-aksa-submit").submit(function(e){
	e.preventDefault();

    var ldMessage       = "Sedang memproses ...";
    var type            = $(this).data("type");
    var dataSocket      = $(this).data("socket");

    if(typeof $(this).data("loadingmessage")!=="undefined"){
        ldMessage       = $(this).data("loadingmessage");
    }

    if(typeof $(this).data("ckeditor")!=="undefined"){
        for ( instance in CKEDITOR.instances ) {
            CKEDITOR.instances[instance].updateElement();
        }
    }

	$.ajax({

		url:$(this).attr('action'),
		data:new FormData(this),
        processData: false,
        contentType: false,
		method:"post",
		beforeSend:function(){
			loadingMessage(ldMessage);
		}

	}).done(function(response){
		$.unblockUI();
        if(typeof dataSocket !=="undefined" && typeof socket !=="undefined" ){
           console.log(dataSocket);
           console.log(response);
           socket.emit(dataSocket,response.results.socket_response);
           response     = {
                success:{
                    code:200,
                    message:"OK"
                },
                status:true,
                results:response.results.results
           }
           console.log(response);
           formNotifResponse(type,response);
        }else{
            formNotifResponse(type,response);
        }
        
		
	}).fail(function(response){

		$.unblockUI();
        var response = response.responseJSON;
        formNotifResponse(type,response);
		
	})
})