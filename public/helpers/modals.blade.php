<!-- media upload -->
<div style="z-index:100000" class="modal fade" id="imageUpload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    	<form id="media-form" action="/upload-attachment" method="post" enctype="multipart/form-data">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal">
	                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
	                </button>
	                <h4 class="modal-title" id="myModalLabel">Upload File</h4>
	            </div>
	            <div class="modal-body">
                    <div class="form-group">
                    	<input type="hidden" name="ajax" value="1">
                        <input id="media" type="file" name="media">
                        <br>
                        <small>Max File Size: 1M</small>
                    </div>
	            </div>
	            <div class="modal-footer">
	                <input type="submit" class="btn btn-primary" data-dismiss="modal" id="insertImage" value="Insert File">
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	            </div><!-- modal-footer -->
	        </div><!-- modal-content -->
        </form>
    </div><!-- modal-dialog -->
</div>

<!-- media library -->


<script>

	// upload attachment through AJAX
    $("body").on({
        click: function(e, data) {
        	e.preventDefault();
        	file = ($('#media:file'))[0].files[0];
            var form_data = new FormData();
            form_data.append('image', file);
            $.ajax({
                type: "post",
                url: "/upload-media",
                data: form_data,
                success: function(response) {
                	console.log(response);
                    $("input#mceu_44-inp").attr("value", response.url);
                },
                cache: false,
                contentType: false,
                processData: false
            });           
        }
    }, "#insertImage");
    
	// upload attachment through AJAX
    // $("body").on({
        // click: function(e, data) {
        	// e.preventDefault();
        	// file = ($('#attachment:file'))[0].files[0];
            // var form_data = new FormData();
            // form_data.append('image', file);
            // $.ajax({
                // type: "post",
                // url: "/upload-attachment",
                // data: form_data,
                // success: function(response) {
                    // $("input#mceu_44-inp").attr("value", response.url);
                // },
                // cache: false,
                // contentType: false,
                // processData: false
            // });           
        // }
    // }, "#media-library");
    
</script>