
function authSubmit(){
	$("#form-auth").submit();
}

$(document).ready(function() {

  

    $("#form-auth").submit(function(e){
    	e.preventDefault();
    	$.ajax({
    		url:$(this).attr('action'),
    		data:$(this).serialize(),
    		method:'post',
    		beforeSend:function(){
    			blockMessage('body','Authenticating . . .','#fff');
    		}
    	}).done(function(response){
    		$('body').unblock();
    		if(response.status){
    			notifSuccess('please wait , redirecting . . . ');	

    			setTimeout(function(){
    				window.location.href = response.data;

    			},2000);

    			return;
    		}else{
    			grecaptcha.reset();
    			notifError(response.data);
    			return;
    		}
    	}).fail(function(){
    		$('body').unblock();
    		grecaptcha.reset();
    		notifError('Something Wrong Please try agian later');
    		return;
    	})
    })
});