$(".switch").bootstrapSwitch();

$(".control-primary, .styled").uniform({
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

function changeStatus(that){
	var id 		= [];

	id[0] 		= $(that).data('id');

	var status 	= (($(that).is(':checked')) ? 'publish' : 'draft');

	$.ajax({
		url:$("#form-bulkaction").attr('action'),
		method:'post',
		data:{data:id,action:status}
	})
	.done(function(response){
		console.log('OK');
	})
	.fail(function(){
		sweetAlert('opps!','Something Wrong Please try again later','error');
	})
}



// Table setup
// ------------------------------

// Setting datatable defaults
$.extend( $.fn.dataTable.defaults, {
    lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "All"]],
    iDisplayLength: 25,
    autoWidth: false,
    order: [],
    columnDefs: [
        { 
            orderable: false,
            width: '100px',
            targets: [ -1 ]
        },
        { 
            orderable: false,
            width: '10px',
            targets: [ 0 ]
        }
    ],
    dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
    language: {
        search: '<span>Filter:</span> _INPUT_',
        lengthMenu: '<span>Show:</span> _MENU_',
        paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
    },
    drawCallback: function () {
        $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
    },
    preDrawCallback: function() {
        $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
    }
});


// Basic datatable
var mydatatable = $('.datatable-basic').DataTable();
//mydatatable.rows( [ '#mydatatable-row-7', '#mydatatable-row-6' ] ).remove().draw();

// Alternative pagination
$('.datatable-pagination').DataTable({
    pagingType: "simple",
    language: {
        paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
    }
});


// Datatable with saving state
$('.datatable-save-state').DataTable({
    stateSave: true
});


// Scrollable datatable
$('.datatable-scroll-y').DataTable({
    autoWidth: true,
    scrollY: 300
});



// External table additions
// ------------------------------

// Add placeholder to the datatable filter option
$('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');


// Enable Select2 select for the length option
$('.dataTables_length select').select2({
    minimumResultsForSearch: Infinity,
    width: 'auto'
});