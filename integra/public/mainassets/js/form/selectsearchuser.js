function formatUserSearch(user){
     if (!user.id) { return user.name; }

      var markup = '<div class="media-left media-middle">'+
	                '<img src="'+user.img_src.xs+'" class="img-circle" style="width:55px;height:55px;object-fit:cover">'+
	            '</div>'+
	            '<div class="media-body media-middle">'+
	                '<b>'+user.name+'</b></br>'+
	                '<span class="text-size-mini"> Username : <span class="text-warning">'+user.username+'</span></span><br>'+
	                '<span class="text-size-mini"> Email : <span class="text-info">'+user.email+'</span></span>'+
	            '</div><div class="clearfix"></div>';

      return markup;
}

function formatUserSelection (repo) {
    return repo.name || repo.text;
}

$(".select-user-search").select2({
    minimumInputLength: 1,
    placeholder:'Cari Pegawai ...',
    ajax: {
        url: APP_URL +"/projects/searchusers",
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