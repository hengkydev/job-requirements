$(".attachment-upload-plus").click(function(){
	var element 	= '<div class="col-xs-2">'+
                            '<div class="attachment-upload">'+
                                 '<label>'+
                                    '<i class="icon-file-upload icon"></i>'+
                                    '<div class="gap-xs"></div>'+
                                    '<span class="text-readmore name">Upload File</span>'+
                                    '<span class="text-readmore size text-xs"></span>'+
                                    '<input type="file" name="attachment[]" class="attachment-upload-input" accept="*">'+
                                '</label>'+
                                '<span class="close" title="Hapus file sisipan">'+
                                    '<i class=" icon-cross3"></i>'+
                                '</span>'+
                            '</div>'+
                        '</div>';
    var parent 		= $(this).parent().parent();
    $(parent).append(element);
    $(".attachment-upload .close").click(function(){
		$(this).parent(".attachment-upload").parent().remove();
	})

	$(".attachment-upload-input").change(function(){
		var input       = this;
		var element 	= $(this).parents(".attachment-upload");
		if (input.files && input.files[0]) {
	        var reader = new FileReader();

	        console.log(input.files[0]);

	        var type 	= input.files[0].type;
	        if(type=="image/jpg" || type=="image/jpeg" || type=="image/png" || type=="image/gif"){
	        	var elIcon 	= '<i class=" icon-image2 text-warning  icon"></i>';	
	        }else if(type=="application/pdf"){
	        	var elIcon 	= '<i class="  icon-file-pdf text-danger  icon"></i>';	
	        } 
	        else if(type=="application/vnd.openxmlformats-officedocument.wordprocessingml.document" || type=="application/msword"	){
	        	var elIcon 	= '<i class="   icon-file-word text-primary  icon"></i>';	
	        } 
	        else if(type=="application/vnd.openxmlformats-officedocument.presentationml.presentation"	){
	        	var elIcon 	= '<i class="    icon-file-text2 text-warning  icon"></i>';	
	        } 
	        else if(type=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){
	        	var elIcon 	= '<i class="     icon-file-excel text-success  icon"></i>';	
	        }else if(type=="video/mp4" || type=="video/x-matroska"){
	        	var elIcon 	= '<i class=" icon-film4 text-pink  icon"></i>';	
	        }
	        else{
	        	var elIcon 	= '<i class="      icon-file-empty text-default  icon"></i>';	
	        }
	        

	        $(element).addClass("fileIn");
	        $(element).find(".icon").remove();
	        $(element).find("label").prepend(elIcon);
	        $(element).find(".text-readmore.name").html(input.files[0].name);
	        $(element).find(".text-readmore.size").html((input.files[0].size).formatMoney(0,',','.')+" Kb");
	        /*$(caption).html(input.files[0].name);

	        reader.onload = function (e) {
	            $(source).attr('src',URL.createObjectURL(input.files[0]));
	            $(source).parent().load();
	            //(source).attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);*/
	    }
	})
})

$(".attachment-upload .close").click(function(){
	$(this).parent(".attachment-upload").parent().remove();
})



$(".attachment-upload-input").change(function(){
	var input       = this;
	var element 	= $(this).parents(".attachment-upload");
	if (input.files && input.files[0]) {
        var reader = new FileReader();

        console.log(input.files[0]);
        
         var type 	= input.files[0].type;
	        if(type=="image/jpg" || type=="image/jpeg" || type=="image/png" || type=="image/gif"){
	        	var elIcon 	= '<i class=" icon-image2 text-warning  icon"></i>';	
	        }else if(type=="application/pdf"){
	        	var elIcon 	= '<i class="  icon-file-pdf text-danger  icon"></i>';	
	        } 
	        else if(type=="application/vnd.openxmlformats-officedocument.wordprocessingml.document" || type=="application/msword"	){
	        	var elIcon 	= '<i class="   icon-file-word text-primary  icon"></i>';	
	        } 
	        else if(type=="application/vnd.openxmlformats-officedocument.presentationml.presentation"	){
	        	var elIcon 	= '<i class="    icon-file-text2 text-warning  icon"></i>';	
	        } 
	        else if(type=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){
	        	var elIcon 	= '<i class="     icon-file-excel text-success  icon"></i>';	
	        }else if(type=="video/mp4" || type=="video/x-matroska"){
	        	var elIcon 	= '<i class=" icon-film4 text-pink  icon"></i>';	
	        }
	        else{
	        	var elIcon 	= '<i class="      icon-file-empty text-default  icon"></i>';	
	        }
        $(element).addClass("fileIn");
        $(element).find(".icon").remove();
        $(element).find("label").prepend(elIcon);
        $(element).find(".text-readmore.name").html(input.files[0].name);
        $(element).find(".text-readmore.size").html((input.files[0].size).formatMoney(0,',','.')+" Kb");
        /*$(caption).html(input.files[0].name);

        reader.onload = function (e) {
            $(source).attr('src',URL.createObjectURL(input.files[0]));
            $(source).parent().load();
            //(source).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);*/
    }
})
