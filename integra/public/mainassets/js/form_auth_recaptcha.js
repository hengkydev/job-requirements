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
			removeAlert();
			mApp.blockPage({
	            overlayColor: '#000000',
	            type: 'loader',
	            state: 'success',
	            message: 'Please wait...'
	        });

		}
	}).done(function(response){
		grecaptcha.reset();
		mApp.unblockPage();
		window.location.href = response.results;
		return;

	}).fail(function(response){
		grecaptcha.reset();
		mApp.unblockPage();

		var response = response.responseJSON;
		alertElement(response.message);

		return;
	})
})

function recaptchaSubmit(){
	$("#form-data").submit();
}