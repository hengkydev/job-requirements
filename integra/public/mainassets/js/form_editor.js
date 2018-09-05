$(".styled").uniform({
    radioClass: 'choice'
});

$(".switch").bootstrapSwitch();

 $('.select2').select2({
	placeholder: "Select a Something",
    minimumResultsForSearch: Infinity
});

$(function() {

    CKEDITOR.replace( 'editor-full', {
        height: '262px',
    });
    
    CKEDITOR.disableAutoInline = true;

});


$("#form-data").submit(function(e){
	e.preventDefault();

	var element 	= $('body');

	for ( instance in CKEDITOR.instances ) {
        CKEDITOR.instances[instance].updateElement();
    }

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