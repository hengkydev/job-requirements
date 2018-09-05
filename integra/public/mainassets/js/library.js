// url
function url(str){

    str = str || "";

    var url = (typeof APP_URL !== 'undefined') ? APP_URL : "";
    url     = (url.charAt(url.length)=="/") ? url.slice(0,url.length - 1) : url;

    if(str!=""){
        str     = (str.charAt(0)=="/") ? str : "/"+str;    
    }

    return url+str;
}

function grecaptchaInit(){

    var element     = $("[element-grecaptcha]");
    var callback    = (typeof $(element).attr("data-callback")!=="undefined") ? $(element).attr("data-callback") : "grecaptchaSubmit";

    if($(element).length>0){

        var grecaptcha = (typeof G_RECAPTCHA_SITE_KEY !== 'undefined') ? G_RECAPTCHA_SITE_KEY : "";

        if(grecaptcha==""){
            return;
        }

        $(element).addClass("g-recaptcha");
        $(element).attr("data-sitekey",grecaptcha);
        $(element).attr("data-callback",callback);
        $("body").append("<script src='https://www.google.com/recaptcha/api.js'></script>");
    }

}

function toUcwords(str)
{
    return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}

$( ".show-password" ).hover(
  function() {
    $( this ).siblings('input[type=password]').attr('type','text');
  }, function() {
    $( this ).siblings('input[type=text]').attr('type','password');
  });

// END DEFAULT
$(".numberformat").keydown(function (e) {
		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				 // Allow: Ctrl+A
				(e.keyCode == 65 && e.ctrlKey === true) ||
				 // Allow: Ctrl+C
				(e.keyCode == 67 && e.ctrlKey === true) ||
				 // Allow: Ctrl+X
				(e.keyCode == 88 && e.ctrlKey === true) ||
				 // Allow: home, end, left, right
				(e.keyCode >= 35 && e.keyCode <= 39)) {
					 return;
		}
		if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
			e.preventDefault();
		}
})

$('.userformat').keypress(function (e) {
    var regex = new RegExp("^[a-zA-Z0-9]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }
    e.preventDefault();
    return false;
});


$('input[alphanum]').keypress(function (e) {
    var regex = new RegExp("^[a-zA-Z0-9]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }

    e.preventDefault();
    return false;
});


$("input[rule='alphaonly']").keypress(function(event){
    var inputValue = event.charCode;

    if(inputValue == 121){
    	return;
    }
    if(!(inputValue >= 65 && inputValue <= 120 ) && (inputValue != 32 && inputValue != 0 ) || inputValue == 32 ){
        event.preventDefault();
    }
});

function goExplode(string,delimiter,result) {
    var response 	= (string).split(delimiter);
    return response[result];
}


function tgl_indo(tgl){
	var tanggal = (tgl).substr(8,2);
	var bulan = "";
 	switch ((tgl).substr(5,2)){
				case '01': 
					bulan= "Januari";
				case '02':
					bulan= "Februari";
				case '03':
					bulan= "Maret";
				case '04':
					bulan= "April";
				case '05':
					bulan= "Mei";
				case '06':
					bulan= "Juni";
				case '07':
					bulan= "Juli";
				case '08':
					bulan= "Agustus";
				case '09':
					bulan= "September";
				case '10':
					bulan= "Oktober";
				case '11':
					bulan= "November";
				case '12':
					bulan= "Desember";
			}

		var tahun = (tgl).substr(0,4);
		return tanggal+' '+bulan+' '+tahun;		 
}

Number.prototype.formatMoney = function(c, d, t){
	  var n = this, 
	      c = isNaN(c = Math.abs(c)) ? 2 : c, 
	      d = d == undefined ? "." : d, 
	      t = t == undefined ? "," : t, 
	      s = n < 0 ? "-" : "", 
	      i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
	      j = (j = i.length) > 3 ? j % 3 : 0;
	     return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
   };

function seo(text) {       
    var characters = [' ', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '+', '=', '_', '{', '}', '[', ']', '|', '/', '<', '>', ',', '.', '?', '--']; 

    for (var i = 0; i < characters.length; i++) {
         var char = String(characters[i]);
         text = text.replace(new RegExp("\\" + char, "g"), '-');
    }
    text = text.toLowerCase();
    return text;
}

function read_more(string,limit){
	string = strip_tags(string);
	if (string.length>limit){
		return string.substr(0,limit)+' . . . ';
	}
	else {
		return string;
	}
}

function strip_tags(input, allowed) {
	  allowed = (((allowed || '') + '')
	    .toLowerCase()
	    .match(/<[a-z][a-z0-9]*>/g) || [])
	    .join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
	  var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
	    commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
	  return input.replace(commentsAndPhpTags, '')
	    .replace(tags, function($0, $1) {
	      return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
	    });
	}


Date.prototype.addHours = function(h) {    
   this.setTime(this.getTime() + (h*60*60*1000)); 
   return this;   
}

function redirect(url){
	window.location.href = url;
}


function parseURLParams(url) {
    var queryStart = url.indexOf("?") + 1,
        queryEnd   = url.indexOf("#") + 1 || url.length + 1,
        query = url.slice(queryStart, queryEnd - 1),
        pairs = query.replace(/\+/g, " ").split("&"),
        parms = {}, i, n, v, nv;

    if (query === url || query === "") {
        return;
    }

    for (i = 0; i < pairs.length; i++) {
        nv = pairs[i].split("=");
        n = decodeURIComponent(nv[0]);
        v = decodeURIComponent(nv[1]);

        if (!parms.hasOwnProperty(n)) {
            parms[n] = [];
        }

        parms[n].push(nv.length === 2 ? v : null);
    }
    return parms;
}

var format_money = function(num){
var str = num.toString().replace("$", ""), parts = false, output = [], i = 1, formatted = null;
if(str.indexOf(",") > 0) {
	parts = str.split(",");
	str = parts[0];
}
str = str.split("").reverse();
for(var j = 0, len = str.length; j < len; j++) {
	if(str[j] != ".") {
		output.push(str[j]);
		if(i%3 == 0 && j < (len - 1)) {
			output.push(".");
		}
		i++;
	}
}
formatted = output.reverse().join("");
return(formatted + ((parts) ? "," + parts[1].substr(0, 2) : ""));
};

$("input[rule='currency']").on('keyup change' , function (e){
	$(this).val(format_money($(this).val()));
})


$(".form-validation input").change(function(e){
	var group 			= $(this).parents('.form-group');

	if($(group).hasClass('has-error')){
		$(group).removeClass('has-error');
		$(group).find('.help-block').remove();
	}
})

$(".form-validation textarea").change(function(e){
	var group 			= $(this).parents('.form-group');

	if($(group).hasClass('has-error')){
		$(group).removeClass('has-error');
		$(group).find('.help-block').remove();
	}
})

var delay = (function(){
              var timer = 0;
              return function(callback, ms){
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
              };
            })();


function ShowNotif(config){

    $.jGrowl.defaults.closer = false;
    $('body').find('.jGrowl').attr('class', '').attr('id', '').hide();


    // type
    var type      = "bg-info";
    var title     = "Informasi";

    switch(config.type){
        case "error":
            type        = "bg-danger";
            title       = "Maaf, ada kesalahan!";
            break;
        case "success":
            type        = "bg-success";
            title       = "Ok, Berhasil!";
            break;
        case "warning": 
            type        = "bg-warning";
            title       = "Peringatan!";
        break;
        default:
            type        = "bg-info";
            title       = "Informasi";
        break;
    }

    $.jGrowl(config.message, {
        position:'top-center',
        header: title,
        theme: 'alert-styled-left '+type
    });
}

function ShowNotifTrevizo(msg,theme){
    $('body').find('.jGrowl').attr('class', '').attr('id', '').hide();

    if(theme=="wishlist"){
        var body    = ' <div class="media-left">'+
                            '<a href="#" class="btn border-warning text-warning btn-flat btn-rounded btn-icon btn-xs an-icon ">'+
                                '<i class="icon-heart6"></i>'+
                            '</a>'+
                        '</div>'+
                        '<div class="media-body">'+
                            '<span class="text-semibold text-md">Keinganan</span><br>'+
                            '<span class="text-sm text-grey-300">'+msg+'</span>'+
                        '</div>';
    }else if(theme=="compare"){
        var body    = ' <div class="media-left">'+
                            '<a href="#" class="btn border-purple text-purple btn-flat btn-rounded btn-icon btn-xs an-icon ">'+
                                '<i class=" icon-transmission"></i>'+
                            '</a>'+
                        '</div>'+
                        '<div class="media-body">'+
                            '<span class="text-semibold text-md">Bandingkan</span><br>'+
                            '<span class="text-sm text-grey-300">'+msg+'</span>'+
                        '</div>';
    }

    $.jGrowl(body, {
        theme: 'jgrowl-trevizo-theme',
        position:'top-right'
    });
}

function blockMessage(element,message,color){
	$(element).block({
        	message: '<span class="text-semibold"><i class="icon-spinner4 spinner position-left"></i>&nbsp; '+message+'</span>',
            overlayCSS: {
                backgroundColor: color,
                opacity: 0.8,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: '10px 15px',
                color: '#fff',
                width: 'auto',
                '-webkit-border-radius': 2,
                '-moz-border-radius': 2,
                backgroundColor: '#333'
            }
        });
}

function loadingMessage(message,element){
    element = element || "body";
    message = message || "Memproses ..."
    $(element).block({ 
        message: '<div class="block-aksa-message"><i class=" icon-spinner2 spinner text-primary"></i> '+message+'</div>',
        overlayCSS: {
            backgroundColor: '#1b2024',
            opacity: 0.8,
            zIndex: 1200,
            cursor: 'wait'
        },
        css: {
            "text-align":"center",
            border: 0,
            color: '#888',
            padding: 0,
            zIndex: 1201,
            backgroundColor: 'transparent'
        }
    });
}

function notifError($message){
    $.jGrowl($message, {
        header: 'Oh! Snap',
         position: 'top-center',
        theme: 'alert-styled-left bg-danger'
    }); 
}

function notifSuccess($message){
    $.jGrowl($message, {
        header: 'Success!',
        position: 'top-center',
        theme: 'alert-styled-left bg-success'
    });     
}

$(".delete-url").click(function(e){
    var url     = $(this).data('url');

    if(url==""){
        return;
    }

    swal({
      title: "Are you sure?",
      text: "This data will deleted permanently",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete it!",
      closeOnConfirm: false
    },
    function(){
      window.location.href = url;
    });
})

$(".confirm-url").click(function(e){
    var url     = $(this).data('url');

    if(url==""){
        return;
    }

    swal({
      title: "Are you sure?",
      text: "This data will be changed",
      type: "info",
      showCancelButton: true,
      confirmButtonColor: "#396DDB",
      confirmButtonText: "Yes, change it!",
      closeOnConfirm: false
    },
    function(){
      window.location.href = url;
    });
})

// INIT TIMER SUPERUSER

function timerSuperuserInit(){
    if($("#date-part").length>0 && $("#time-part").length>0){
        var interval = setInterval(function() {
            var momentNow = moment();
            $('#date-part').html(momentNow.format('YYYY MMMM DD'));
            $('#time-part').html(momentNow.format('A hh:mm:ss'));
        }, 100);    
    }
}

$("[showhide-password-button]").click(function(){
    var form        = $(this).parents("[showhide-password]");
    var input       = $(form).find("input[showhide-password-element]");
    var showClass   = $(form).data('showclass');
    var hideClass   = $(form).data('hideclass');
    var button      = $(this);

    console.log(showClass);
    
    if($(input).attr("type")=="password"){

        $(input).attr("type","text");
        $(button).removeClass(hideClass);
        $(button).addClass(showClass);

    }else{
        $(input).attr("type","password");
        $(button).removeClass(showClass);
        $(button).addClass(hideClass);
    }

})

$(".uploader-preview-img").change(function(){

    var src     = $(this).data("src");
    var text    = $(this).data("text");
    var input   = this;

     if (input.files && input.files[0]) {
        var reader = new FileReader();

        $(text).html(input.files[0].name);

        reader.onload = function (e) {

            $(src).attr('href', e.target.result);
            $(src).attr('src', e.target.result);
            /*$(lightbox).attr('href', e.target.result);
            $(image).attr('src', e.target.result);*/

        }

        reader.readAsDataURL(input.files[0]);
    }


})

// WEBSITE
$("label.checkbox-country input[type=checkbox]").change(function(){
    if($(this).is(":checked")){
        $(this).parents(".checkbox-country").addClass("active");
    }else{
        $(this).parents(".checkbox-country").removeClass("active");
    }
})

$(".aksa-file-upload-preview").change(function(){
    console.log("asdasd");
    var caption   = $(this).data("caption");
    var source    = $(this).data("source");
    var input       = this;
    console.log("caption",caption);
    console.log("source",source);
     if (input.files && input.files[0]) {
        var reader = new FileReader();

        console.log();

        $(caption).html(input.files[0].name);

        reader.onload = function (e) {
            $(source).attr('src',URL.createObjectURL(input.files[0]));
            $(source).parent().load();
            //(source).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }

})

$(".aksa-show-hide").change(function(){
    var show    = $(this).data('show');
    var hide    = $(this).data('hide');
    console.log(show);
    $(hide).fadeOut(function(){
        $(show).fadeIn();
    })
})

$(".youtube-preview-embed").change(function(){
    var target  = $(this).data('target');
    var url     = $(this).val();
    var id      = url.split("?v=")[1];

    var embedlink = "http://www.youtube.com/embed/" + id;
    $(target).attr("src",embedlink);
})
var delay = (function(){
                  var timer = 0;
                  return function(callback, ms){
                    clearTimeout (timer);
                    timer = setTimeout(callback, ms);
                  };
                })();


// INIT APP
grecaptchaInit();
timerSuperuserInit();

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var cssRule =
    "display:block;width:200px;border-radius:0px;padding:3px 15px;background:#108bc3;color:#FFF;" +
    "font-size: 30px;font-family:Arial, Helvetica, sans-serif" +
    "font-weight: bold;";
var cssRule2 =
    "display:block;border-radius:0px;padding:3px 15px;background:#fff;color:#666;" +
    "font-size: 30px;font-family:Arial, Helvetica, sans-serif;";
    console.log("%cAKSAMEDIA"+"%cSystem,Apps & Website Development", cssRule,cssRule2);
    var cssRule =
        "border-radius:0px;padding:3px 15px;background:#333;color:#fff;" +
        "font-size: 12px;" +
        "font-weight: bold;";
        var cssRule2 =
        "border-radius:0px;padding:3px 0px;background:#333;color:#FF5722;padding-left:0px;" +
        "font-size: 12px;" +
        "font-weight: bold;";
     var cssRule3 =
        "border-radius:0px;padding:3px 15px;background:#333;color:#108bc3;" +
        "font-size: 12px;" +
        "font-weight: bold;";
    console.log("%cThis Website Development by Aksamedia Visit"+"%c@"+"%caksamedia.com", cssRule,cssRule2,cssRule3);