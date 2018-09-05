$(".switch").bootstrapSwitch();

$(".control-primary").uniform({
    radioClass: 'choice'
});

$("#checkbox-all").click(function(){
	if($(this).is(':checked')){
		$('input[name="data[]"]').prop('checked',true);
	}else{
		$('input[name="data[]"]').prop('checked',false);
	}
	$.uniform.update();
})

$("#form-bulkaction").submit(function(e){
	e.preventDefault();

	if($('input[name="data[]"]:checked').length<=0){
		sweetAlert('opps!','Please Select Data First!','warning');
		return;
	}

	swal({
	  title: "Are you sure?",
	  text: "You will do this action",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Yes, im sure!",
	  closeOnConfirm: false
	},
	function(){
	  $("#form-bulkaction").unbind();
	  $("#form-bulkaction").submit();
	});

})

$("a.transaction-status").click(function(){
    var data    = $(this).data('status');
    $("input[name=by]").val(data);
    $("#form-transaction").submit();
})

$(".form-change-transaction").change(function(){
    $("#form-transaction").submit();
})