 function containerHeight() {
    var availableHeight = $(window).height() - $('.page-container').offset().top - $('.navbar-fixed-bottom').outerHeight();

    $('.page-container').attr('style', 'min-height:' + availableHeight + 'px');
}

var container 	= $("#container-data-api");

var html = '<div class="panel-flat panel">'+
				'<div class="panel-heading">'+
                    '<h6 class="panel-title "><span class="status-mark border-blue position-left"></span> Data API<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>'+
                    '<div class="heading-elements">'+
                        '<ul class="icons-list">'+
                            '<li><a data-action="collapse"></a></li>'+
                            '<li><a data-action="reload"></a></li>'+
                            '<li><a data-action="close"></a></li>'+
                        '</ul>'+
                    '</div>'+
                '</div>'+
                '<div class="panel-body">'+
                    '<div class="row">'+
                        '<div class="col-sm-4">'+
                            '<div class="form-group">'+
                                '<label>Nama data <b class="text-danger">*</b></label>'+
                                '<input type="text" name="data_name[]" placeholder="Ketik nama data di sini . ." class="form-control" required="">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-4">'+
                            '<div class="form-group">'+
                                '<label>Method data <b class="text-danger">*</b></label>'+
                                '<select class="form-control" name="data_method[]" required="">'+
                                    '<option value="get">GET</option>'+
                                    '<option value="post">POST</option>'+
                                    '<option value="put">PUT</option>'+
                                    '<option value="delete">DELETE</option>'+
                                '</select>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-4">'+
                            '<div class="form-group">'+
                                '<label>Required ? </label>'+
                                '<div class="checkbox checkbox-switch">'+
                                    '<label>'+
                                        '<input type="checkbox" name="data_required[]" data-on-text="Required" data-on-color="success" data-off-text="Optional" data-off-color="default" class="switch" data-size="mini" checked="checked" value="1">'+
                                    '</label>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-md-12">'+
                            '<textarea class="form-control" name="data_description[]" placeholder="Deskripsi data API"></textarea>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>';

$("#api-add-data").click(function(){
	$(container).append(html);
	$(".switch").bootstrapSwitch();

	 $('.panel [data-action=collapse]').click(function (e) {
        e.preventDefault();
        var $panelCollapse = $(this).parent().parent().parent().parent().nextAll();
        $(this).parents('.panel').toggleClass('panel-collapsed');
        $(this).toggleClass('rotate-180');

        containerHeight(); // recalculate page height

        $panelCollapse.slideToggle(150);
    });

	$('.panel [data-action=close]').click(function (e) {
	    e.preventDefault();
	    var $panelClose = $(this).parent().parent().parent().parent().parent();

	    containerHeight(); // recalculate page height

	    $panelClose.slideUp(150, function() {
	        $(this).remove();
	    });
	});

	$('.panel [data-action=reload]').click(function (e) {
        e.preventDefault();
        var block = $(this).parent().parent().parent().parent().parent();
        $(block).block({ 
            message: '<i class="icon-spinner2 spinner"></i>',
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.8,
                cursor: 'wait',
                'box-shadow': '0 0 0 1px #ddd'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'none'
            }
        });

        // For demo purposes
        window.setTimeout(function () {
           $(block).unblock();
        }, 2000); 
    });
})




