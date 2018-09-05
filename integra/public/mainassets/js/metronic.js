function alertElement(message,type){

	var error_html = '<div class="gap-md"></div><div class="alert alert-danger alert-dismissible fade show   m-alert m-alert--air" role="alert" >'+
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>'+
							'<strong>'+
								'Maaf ada yang salah !'+
							'</strong>'+
							'<br>'+message+
						'</div>';

	var success_html 	= '<div class="gap-md"></div>'+
							'<div class="alert alert-accent alert-dismissible fade show   m-alert m-alert--square m-alert--air" role="alert">'+
								'<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>'+
								'<strong>Berhasil !</strong><br>'+message
							'</div>';

	if(type){
		$("#alert-showing").html(success_html);
	}else{
		$("#alert-showing").html(error_html);
	}
}

function removeAlert(){
	$("#alert-showing").html('');
}