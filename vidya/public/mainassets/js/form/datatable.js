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

function changeStatus(that){
	var id 		= [];

	id[0] 		= $(that).data('id');

    var datatrue    = $(that).data("truevalue");
    var datafalse   = $(that).data("falsevalue");

	var status 	= (($(that).is(':checked')) ? datatrue : datafalse);

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

$(function() {


    // Table setup
    // ------------------------------

    // Setting datatable defaults
    $.extend( $.fn.dataTable.defaults, {
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
    $('.datatable-basic').DataTable();


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
    
});

$("a.form-change-value").click(function(){
    var data        = $(this).data('status');
    var selector    = $(this).data("selector");
    $('#form-data input[name="'+selector+'"]').val(data);
    $("#form-data").submit();
})

$(".form-change-trigger").change(function(){
    $("#form-data").submit();
})

$(".quickview-task").click(function(){

    var task    = $(this).data("task");

    if(task==""){
        return;
    }

    $.ajax({
        url:"/projects/taskxhr",
        data:{task:task},
        method:"post",
        beforeSend:function(){
            loadingMessage("Sedang Memprosess ...");
        }

    }).done(function(response){
        $.unblockUI();
        $("#modal_view_task .modal-body").html(response.results);
        $("#modal_view_task").modal("show");

    }).fail(function(response){

        $.unblockUI();
        return;
        
    })

})

$(".change-task").click(function(){

    var task    = $(this).data("task");

    if(task==""){
        return;
    }

    $.ajax({
        url:"/projects/taskxhrupdate",
        data:{task:task},
        method:"post",
        beforeSend:function(){
            loadingMessage("Sedang Memprosess ...");
        }

    }).done(function(response){
        $.unblockUI();
        $("#modal_update_task form").html(response.results);

        if($("#editor-small").length>0){
            CKEDITOR.replace( 'editor-small-2', {
                height: '180px',
                toolbarGroups: [
                    {"name":"basicstyles","groups":["basicstyles"]},
                    {"name":"links","groups":["links"]},
                    {"name":"paragraph","groups":["list","blocks"]},
                    {"name":"insert","groups":["insert"]},
                    {"name":"styles","groups":["styles"]},
                    { name: 'tools', "groups": [ 'Maximize'] }
                ],
            });
            
            CKEDITOR.disableAutoInline = true;    
        }

        $(".select-user-search-task").select2({
            minimumInputLength: 1,
            placeholder:'Cari Pegawai ...',
            ajax: {
                url: APP_URL +"/projects/searchuserstask",
                type: "POST",
                quietMillis: 50,
                data: function (term) {
                    return {
                        keyword: term,
                        project:$("#project-value").val(),
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                   return {
                        results: data.results,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 1,
            templateResult: formatUserSearch, // omitted for brevity, see the source of this page
            templateSelection: formatUserSelection // omitted for brevity, see the source of this page
        });

        $("#modal_update_task").modal("show");

    }).fail(function(response){

        $.unblockUI();
        return;
        
    })

})

function quickViewTask(id){
     var task    = id;

    if(task==""){
        return;
    }

    $.ajax({
        url:"/projects/taskxhr",
        data:{task:task},
        method:"post",
        beforeSend:function(){
            loadingMessage("Sedang Memprosess ...");
        }

    }).done(function(response){
        $.unblockUI();
        $("#modal_view_task .modal-body").html(response.results);
        $("#modal_view_task").modal("show");

    }).fail(function(response){

        $.unblockUI();
        return;
        
    })
}