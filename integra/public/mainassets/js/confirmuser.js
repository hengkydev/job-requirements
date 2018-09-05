// ALL STEP
 $(".styled").uniform();
$(document).ready(function(){
    $(".select-2").select2();
    // Toolbar extra buttons
    var btnFinish = $('<button type="submit">Selesai &nbsp;<i class="fa fa-check"></i></button>')
                                     .addClass('btn bg-primary-600')
                                     .on('click', function(){ 
                                            if( !$(this).hasClass('disabled')){ 
                                                var elmForm = $("#form-data");
                                                if(elmForm){
                                                    elmForm.validator('validate'); 
                                                    var elmErr = elmForm.find('.has-error');
                                                    if(elmErr && elmErr.length > 0){
                                                        alert('Oops we still have error in the form');
                                                        return false;    
                                                    }else{
                                                        elmForm.submit();
                                                        return false;
                                                    }
                                                }
                                            }
                                        });
    var btnCancel = $('<button></button>').text('Setel Ulang')
                                     .addClass('btn bg-grey')
                                     .on('click', function(){ 
                                            $('#smartwizard').smartWizard("reset"); 
                                            $('#form-data').find("input, textarea").val(""); 
                                        });                         
    
    
    
    // Smart Wizard
	    $('#smartwizard').smartWizard({ 
            selected: 0, 
            theme: 'arrows',
            transitionEffect:'fade',
            lang: {  // Language variables
                next: 'Selanjutnya', 
                previous: 'Sebelumnya'
            },
            toolbarSettings: {toolbarPosition: 'bottom',
                              toolbarExtraButtons: [btnFinish]
                            },
            anchorSettings: {
                        markDoneStep: true, // add done css
                        markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                        removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
                        enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
                    }
         });
    
    $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
        console.log(stepNumber);
        var elmForm = $("#form-step-" + stepNumber);
        // stepDirection === 'forward' :- this condition allows to do the form validation 
        // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
        if(stepDirection === 'forward' && elmForm){
            elmForm.validator('validate'); 
            var elmErr = elmForm.find('.has-error');
            if(elmErr && elmErr.length > 0){
                // Form validation failed
                return false;    
            }
        }
        return true;
    });
    
    $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
        // Enable finish button only on last step
        if(stepNumber == 5){ 
            $('.btn-finish').removeClass('disabled');  
        }else{
            $('.btn-finish').addClass('disabled');
        }
    });                               
    
});

// # STEP 3

var url_province 		= '/getdata/ongkirlocation/province';
var url_city 			= '/getdata/ongkirlocation/city';
var url_district 		= '/getdata/ongkirlocation/district';
var element 			= 'body';

var el_courier_province = $("#form-province");
var el_courier_city 	= $("#form-city");
var el_courier_district	= $("#form-district");

$(el_courier_province).change(function(){

	if($(this).val()==""){
		$(el_courier_city).html('<option value="">- Pilih Kota</option>');
		$(el_courier_city).prop('disabled',true);
		$(el_courier_city).select2();

		$(el_courier_district).html('<option value="">- Pilih Kecamatan</option>');
		$(el_courier_district).prop('disabled',true);
		$(el_courier_district).select2();
		return;
	}

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
		var html 	= '<option value="">- Pilih Kota</option>';
		$.each(response.results, function(index, item) {
		    html 	+= '<option value="'+item.id+'//'+item.name+' ('+item.type+')">'+item.name+' ('+item.type+')</option>';
		});

		$(el_courier_district).html('<option value="">- Pilih Kota</option>');
		$(el_courier_district).prop('disabled',true);
		$(el_courier_district).select2();

		$(el_courier_city).html(html);
		$(el_courier_city).prop('disabled',false);
		$(el_courier_city).select2();
	})
	.fail(function(response){
		var response = response.responseJSON;
		$(element).unblock();
		sweetAlert("Oops...",response.message, "error");
	})

	
})


$(el_courier_city).change(function(){

	if($(this).val()==""){
		$(el_courier_district).html('<option value="">- Pilih Kecamatan</option>');
		$(el_courier_district).prop('disabled',true);
		$(el_courier_district).select2();
		return;
	}

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
		var html 	= '<option value="">- Pilih Kecamatan</option>';
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

// #STEP 4
$("#upload-file").change(function(){
	var element 	= $("#image-preview");
	var input 		= this;
	console.log(input.files);
	if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(element).attr('src', e.target.result);
            //jQuery(element).parent().attr('href',e.target.result);
            //jQuery("#show-read-only").val(jQuery('#img-change-konf').attr('src'));
        }
        reader.readAsDataURL(input.files[0]);
        
    }
})


