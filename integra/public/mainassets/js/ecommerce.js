
function updateCart(that){
	var parent 		= $(that).parents('.container-cart-system');
	var product 	= $(parent).find('input[name=product]').val();
	var rowid 		= $(parent).find('input[name=rowid]').val();
	var qty 		= parseInt($(parent).find('input[name=qty]').val());
	var old_qty 	= qty;
	var alert 		= $(parent).find(".alert-modal");

	if($(that).data('type')=='plus'){
		qty++;
	}
	else if($(that).data('type')=="minus"){
		qty--;
	}

	qty 			= ((qty<=0) ? 0 : qty);

	var option 		= {
		id:rowid,
		product:product,
		qty:qty
	}

	$.ajax({
		url:'/cart/update',
		data:option,
		method:'POST',
		beforeSend:function(){
			blockMessage($(parent),"Processing  . .. ","#fff");
		}
	})
	.done(function(response){
		$(parent).unblock();
		$("#nav-cart").html(response.results.html_nav);
		$(parent).find('input[name=qty]').val(response.results.item.qty);
		$(alert).html("");

	})
	.fail(function(response){
		response = response.responseJSON;
		$(parent).unblock();
		$(parent).find('input[name=qty]').val(old_qty);
		var alert_danger = '<div class="alert alert-danger">'+
				            '<strong>Ada sesuatu yang salah !</strong>&nbsp;&nbsp;'+response.message+
				           '</div>';
		$(alert).html(alert_danger);
	})
}




var link_cart = $(".link-cart").click(function(){
	var id 			= $(this).data('id');
	var element		= $('body');
	var mdl_success	= $("#modal-cart");
	var mdl_error 	= $("#modal-error-cart");

	if(id==""){
		return;
	}

	$(mdl_success).modal('hide');
	$(mdl_error).modal('hide');

	$.ajax({
		url:'/cart/add',
		data:{id:id,qty:1},
		method:'POST',
		beforeSend:function(){
			$(element).block();
		}
	}).done(function(response){

		$(element).unblock();
		$("#nav-cart").html(response.results.html_nav);
		$(mdl_success).html(response.results.html_modal);
		$(mdl_success).modal('show');

	})
	.fail(function(response){

		var response = response.responseJSON;
		$(element).unblock();
		$(mdl_error).find(".explain-block").html('"'+response.message+'"');
		$(mdl_error).modal('show');

	})
})


var link_compare = $(".link-compare").click(function(){
	var id 			= $(this).data('id');
	var element		= $('body');
	$.ajax({
		url:'/compare/add',
		data:{id:id},
		method:'POST',
		beforeSend:function(){
			blockMessage($(element),"Processing  . .. ","#fff");		
		}
	}).done(function(response){
		$(element).unblock();
		$("#compare-element").html(response.results.html);
		ShowNotif('success','Added To Your Compare List','bg-success');
	})
	.fail(function(response){
		var response = response.responseJSON;
		$(element).unblock();
		ShowNotif('Opps!',response.message,'bg-danger');
	})	
})

var link_wishlist = $(".link-wishlist").click(function(){
	var id 			= $(this).data('id');
	var element		= $('body');
	$.ajax({
		url:'/user/wishlist/add',
		data:{product:id},
		method:'POST',
		beforeSend:function(){
			blockMessage($(element),"Processing  . .. ","#fff");		
		}
	}).done(function(response){
		$(element).unblock();
		ShowNotifTrevizo('Produk di tambahkan','wishlist');
	})
	.fail(function(response){
		var response = response.responseJSON;
		$(element).unblock();
		sweetAlert({
			title:'Opps!',
			text:response.message,
			type:"warning",
		});
	})	
})


function removeCart(that){

	var type 			= $(that).data('type');

	if(type=="modal"){
		var element 	= $(that).parents('.container-cart-system');
	}else if(type=="nav"){
		var element 	= $("#nav-cart");
	}else{
		var element 	= $('body');
	}

	var id 				= $(that).data('id');

	$.ajax({
		url:'/cart/removequick',
		data:{id:id},
		method:'POST',
		beforeSend:function(){
			blockMessage($(element),"Processing  . .. ","#fff");		
		}
	}).done(function(response){
		$(element).unblock();
		$("#nav-cart").html(response.results.html_nav);
		if(type=="modal"){
			$("#modal-cart").modal('hide');
		}
	})
	.fail(function(response){
		var response = response.responseJSON;
		$(element).unblock();
	})
	
}

function removeCompare(id){
var element		= $('body');

	$.ajax({
		url:'/compare/remove',
		data:{id:id},
		method:'POST',
		beforeSend:function(){
			blockMessage($(element),"Processing  . .. ","#fff");		
		}
	}).done(function(response){
		$(element).unblock();
		$(element).html(response.results.html);
	})
	.fail(function(data){
		var response = response.responseJSON;
		$(element).unblock();
		ShowNotif('Opps!',response.message,'bg-danger');
	})
	
}



$(".link-quickview").click(function(){
	var id 			= $(this).data('id');
var element		= $('body');

	$.ajax({
		url:'/product/quickview',
		data:{id:id},
		method:'POST',
		beforeSend:function(){
			blockMessage($(element),"Processing  . .. ","#fff");		
		}
	}).done(function(response){
		$(element).unblock();
		$("#modal-quickview").find('.modal-body').html(response.results).promise().done(function(){

			var asd = setTimeout(function(){
				$('#modal-quickview .thumbnail-container .bxslider').bxSlider({
		        slideWidth: 94,
		        slideMargin: 5,
		        minSlides: 4,
		        maxSlides: 4,
		        pager: false,
		        speed: 500,
		        pause: 3000
		    });	
			},200)

		    $(".share-sosmed").jsSocials({
		        shares: ["twitter", "facebook", "googleplus", "linkedin", "pinterest", "whatsapp"]
		    });

		    $("#modal-quickview").modal('show');

		    $(".link-cart-modal").click(function(){
				var id 			= $(this).data('id');
				var element		= $('#modal-quickview .modal-dialog');

				if(id==""){
					return;
				}

				$.ajax({
					url:'/cart/add',
					data:{id:id,qty:1},
					method:'POST',
					beforeSend:function(){
						blockMessage($(element),"Processing  . .. ","#fff");		
					}
				}).done(function(response){
					$(element).unblock();
					$("#nav-cart").html(response.results.html);
					ShowNotif('success','Added To Your Cart','bg-success');
					$("#modal-quickview").modal('hide');
				})
				.fail(function(response){
					var response = response.responseJSON;
					$(element).unblock();
					ShowNotif('Opps!',response.message,'bg-danger');

				})
		    	
		    })

		    $(".link-compare-modal").click(function(){
				var id 			= $(this).data('id');
				var element		= $('#modal-quickview .modal-dialog');
				console.log('asd');
				$.ajax({
					url:'/compare/add',
					data:{id:id},
					method:'POST',
					beforeSend:function(){
						blockMessage($(element),"Processing  . .. ","#fff");		
					}
				}).done(function(response){
					$(element).unblock();
					$("#compare-element").html(response.results.html);
					ShowNotif('success','Added To Your Compare List','bg-success');
					$("#modal-quickview").modal('hide');
				})
				.fail(function(response){
					var response = response.responseJSON;
					$(element).unblock();
					ShowNotif('Opps!',response.message,'bg-danger');
				})
			})

					
		});		

		

	    
	})
	.fail(function(data){
		var response = response.responseJSON;
		$(element).unblock();
		ShowNotif('Opps!',response.message,'bg-danger');

	})
	
})

