$(".switch").bootstrapSwitch();

$(".styled").uniform({
    radioClass: 'choice'
});

 $('.select2').select2({
	placeholder: "Select a Something",
    minimumResultsForSearch: Infinity
});

$("#form-data").submit(function(e){
	e.preventDefault();

	var element 	= $('body');

	$.ajax({
		url:$(this).attr('action'),
		method:'post',
		data:new FormData(this),
  		processData: false,
  		contentType: false,
		beforeSend:function(){
			blockMessage(element,'Please Wait . . . ','#fff');
		}
	}).done(function(response){

		$(element).unblock();
		window.location.href = response.results;
		return;

	}).fail(function(response){
		var response = response.responseJSON;
		$(element).unblock();

		sweetAlert({
			title:'Opps!',
			text:response.message,
			type:"error",
		});
		return;
	})
})