var AppInbox = function () {

    var content = $('.inbox-content');
	
    var initFileupload = function () {

        $('#fileupload').fileupload({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: 'upload.php',
            autoUpload: true
        });

    }

    var loadCompose = function (el,id = 0) {

        var url = 'nueva_tarea.php?id_usuario='+id;

		App.blockUI(
			{
	            message: 'Cargando...'
	        }
		);

        // load the form via ajax
        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            success: function(res) 
            {
                App.unblockUI();

                $('.inbox-nav > li.active').removeClass('active');
                $('.inbox-header > h1').text('Nueva Tarea');
                $('#subtitulo').hide();

                content.html(res);
                initFileupload();
                Layout.fixContentHeight();

            },
            async: false
        });
    }


    return {
        //main function to initiate the module
        init: function () {

            // handle compose btn click
            $('.inbox').on('click', '.compose-btn', function () {
                loadCompose($(this));
            });

            $('.componer').on('click', function () {
                loadCompose($(this));
            });

            $('.componer_sidebar').on('click', function () {
	            var id = $(this).attr('id_usuario');
                loadCompose($(this),id);
            });


            //handle loading content based on URL parameter
           if (App.getURLParameter("a") === "compose") {
                loadCompose();
            } 

        }

    };

}();

jQuery(document).ready(function() {
    AppInbox.init();
});