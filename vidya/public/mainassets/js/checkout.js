
var url_province 		= '/getdata/ongkirlocation/province';
var url_city 			= '/getdata/ongkirlocation/city';
var url_district 		= '/getdata/ongkirlocation/district';
var url_cost 			= '/getdata/ongkircost';
var element 			= 'body';

var el_courier_province = $("#courier-province");
var el_courier_city 	= $("#courier-city");
var el_courier_district	= $("#courier-district");
var el_courier_service  = $(".courier-service");
var el_courier_packet 	= $(".courier-packet");
var el_courier_cost 	= $(".courier-cost");

var txt_courier_name 	= $(".text-courier-name");
var txt_courier_packet 	= $(".text-courier-packet");
var txt_courier_estimation 	= $(".text-courier-estimation");
var txt_courier_cost 	= $(".text-courier-cost");


$(".check-courier-custom").change(function(){
	var parent 					= $(this).parents('.panel-courier');
	var parent_default 			= $(this).parents('.panel-courier').find('.default-courier-box');
	var parent_custom 			= $(this).parents('.panel-courier').find('.custom-courier-box');

	$(parent).find(el_courier_service).prop('checked',false);
	$.uniform.update('.styled');
	$(parent).find(el_courier_packet).html('<option value="">Pilih paket kurir</option>');
	$(parent).find(el_courier_packet).prop('disabled',true);
	$(parent).find(el_courier_cost).val(0);

	$(parent).find(txt_courier_name).html('---');
	$(parent).find(txt_courier_packet).html('---');
	$(parent).find(txt_courier_estimation).html('---');
	$(parent).find(txt_courier_cost).html('-,-');

	if($(this).is(':checked')){
		$(parent_default).fadeOut(function(){
			$(parent_default).find(".default-courier").prop('required',false);
			$(parent_default).find(".default-courier").removeClass('required');
			$(parent_custom).find('.custom-courier').prop('required',true);
			$(parent_custom).find('.custom-courier').addClass('required');
			$(parent_custom).fadeIn();
		})
	}else{
		$(parent_custom).fadeOut(function(){
			$(parent_custom).find(".custom-courier").prop('required',false);
			$(parent_custom).find(".custom-courier").removeClass('required');
			$(parent_default).find('.default-courier').prop('required',true);
			$(parent_default).find('.default-courier').addClass('required');
			$(parent_default).fadeIn();
		})
	}

	countCourierCost();
})


function resetCourierData(){

	$(el_courier_service).prop('checked',false);
	$.uniform.update('.styled');
	$(el_courier_packet).html('<option value="">Pilih paket kurir</option>');
	$(el_courier_packet).prop('disabled',true);
	$(el_courier_cost).val(0);
	countCourierCost();
}

function countCourierCost(){

	var cost 			= 0;

	$.each(el_courier_cost, function (key, val) {
        cost 			= cost + parseInt($(this).val());
    });

	var product_total 	= parseInt($("input[name=product_total]").val());
	var grand_total 	= product_total + cost;

	$("#courier-cost").html("Rp. "+(cost).formatMoney(0,',','.'));
	$("#grand-total").html("Rp. "+(grand_total).formatMoney(0,',','.'));

}


$(el_courier_province).change(function(){

	if($(this).val()==""){
		$(el_courier_city).html('<option value=""></option>');
		$(el_courier_city).prop('disabled',true);
		$(el_courier_city).select2();

		$(el_courier_district).html('<option value=""></option>');
		$(el_courier_district).prop('disabled',true);
		$(el_courier_district).select2();
		
		resetCourierData();
		return;
	}
	resetCourierData();

	$.ajax({
		url:url_city,
		method:'POST',
		data:{province:$(this).val()},
		beforeSend:function(){
			blockMessage(element,"Please Wait Getting data  . . .","#fff");
		}
	})
	.done(function(response){
		$(element).unblock();
		var html 	= '<option value=""></option>';
		$.each(response.results, function(index, item) {
		    html 	+= '<option value="'+item.id+'//'+item.name+' ('+item.type+')">'+item.name+' ('+item.type+')</option>';
		});

		$(el_courier_district).html('<option value=""></option>');
		$(el_courier_district).prop('disabled',true);
		$(el_courier_district).select2();

		$(el_courier_city).html(html);
		$(el_courier_city).prop('disabled',false);
		$(el_courier_city).select2();

		countCourierCost();
	})
	.fail(function(response){
		var response = response.responseJSON;
		$(element).unblock();
		sweetAlert("Oops...",response.message, "error");
		countCourierCost();
	})

	
})


$(el_courier_city).change(function(){

	if($(this).val()==""){
		$(el_courier_district).html('<option value=""></option>');
		$(el_courier_district).prop('disabled',true);
		$(el_courier_district).select2();
		resetCourierData();
		return;
	}

	resetCourierData();

	$.ajax({
		url:url_district,
		method:'POST',
		data:{city:$(this).val()},
		beforeSend:function(){
			blockMessage(element,"Please Wait Getting data  . . .","#fff");
		}
	})
	.done(function(response){
		$(element).unblock();
		var html 	= '<option value="">- Select District</option>';
		$.each(response.results, function(index, item) {
		    html 	+= '<option value="'+item.id+'//'+item.name+'">'+item.name+'</option>';
		});

		$(el_courier_district).html(html);
		$(el_courier_district).prop('disabled',false);
		$(el_courier_district).select2();
		countCourierCost();
	})
	.fail(function(response){
		var response = response.responseJSON;
		$(element).unblock();
		sweetAlert("Oops...",response.message, "error");
		countCourierCost();
	})
	
})


$(el_courier_service).change(function(){

	var parent 		= $(this).parents('.panel-courier');

	if($(this).val()==""){
		$(parent).find(el_courier_packet).html('<option value="">Pilih paket kurir</option>');
		$(parent).find(el_courier_packet).prop('disabled',true);
		$(parent).find(txt_courier_name).html('---');
		$(parent).find(txt_courier_packet).html('---');
		$(parent).find(txt_courier_estimation).html('---');
		$(parent).find(txt_courier_cost).html('-,-');
		countCourierCost();
		return;
	}

	$(parent).find(el_courier_packet).html('<option value="">Pilih paket kurir</option>');
	$(parent).find(el_courier_packet).prop('disabled',true);
	$(parent).find(txt_courier_name).html('---');
	$(parent).find(txt_courier_packet).html('---');
	$(parent).find(txt_courier_estimation).html('---');
	$(parent).find(txt_courier_cost).html('-,-');
	$(parent).find(el_courier_cost).val(0);

	var courier 	= $(this).val();
	var province 	= $(el_courier_province).val();
	var city 		= $(el_courier_city).val();
	var district 	= $(el_courier_district).val();
	var weight 		= $(parent).find('input.courier-weight').val();
	var vendor 		= $(parent).data('id');

	if(province=="" || city=="" || district==""){
		ShowNotif('Opps!','Mohon pilih lokasi anda terlebih dahulu','bg-danger');
		resetCourierData();
		return;
	}

	$.ajax({
		url:url_cost,
		method:'POST',
		data:
		{
				weight:weight,
				destination:district,
				courier:courier,
				vendor:vendor
		},
		beforeSend:function(){
			blockMessage(element,"Please Wait Getting data  . . .","#fff");
		}
	})
	.done(function(response){
		$(element).unblock();

		var html 	= '<option value="">Pilih paket kurir</option>';

		$.each(response.results, function(index, item) {
		    html 	+= '<option value="'+item.name+'//'+item.cost+'//'+item.estimation+'">'
		    			+item.name
		    			'</option>';
		});

		$(parent).find(el_courier_packet).html(html);
		$(parent).find(el_courier_packet).prop('disabled',false);
		countCourierCost();
	})
	.fail(function(response){
		var response = response.responseJSON;
		$(element).unblock();
		sweetAlert("Oops...",response.message, "error");
		countCourierCost();
	})

})


$(el_courier_packet).change(function(){
	var parent 		= $(this).parents('.panel-courier');

	if($(this).val()==""){
		$(parent).find(txt_courier_name).html('---');
		$(parent).find(txt_courier_packet).html('---');
		$(parent).find(txt_courier_estimation).html('---');
		$(parent).find(txt_courier_cost).html('-,-');
		$(parent).find(el_courier_cost).val(0);
		countCourierCost();
		return;
	}

	var estimation 	= goExplode($(this).val(),'//',2);
	var cost 		= goExplode($(this).val(),'//',1);
	var name 		= goExplode($(this).val(),'//',0);

	$(parent).find(txt_courier_packet).html(name);
	$(parent).find(txt_courier_estimation).html(estimation+' hari');
	$(parent).find(txt_courier_cost).html('Rp. '+parseInt(cost).formatMoney(0,',','.'))
	$(parent).find(el_courier_cost).val(cost);
	
	countCourierCost();

})


function checkoutSubmit(){
	$("#form-checkout").submit();
}

$("#form-checkout").submit(function(e){
	e.preventDefault();

	$.ajax({
		url:$(this).attr('action'),
		method:'post',
		data:new FormData(this),
  		processData: false,
  		contentType: false,
		beforeSend:function(){
			blockMessage('body','Authenticating . . .','#fff');
		}
	}).done(function(response){
		$('body').unblock();
		console.log(response.results);
		window.location.href = response.results;
		return;
	}).fail(function(response){
		$('body').unblock();
		grecaptcha.reset();
		var response = response.responseJSON;
		$(element).unblock();
		sweetAlert("Oops...",response.message, "error");
	})
})