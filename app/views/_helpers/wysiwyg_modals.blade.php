<!-- media upload -->
<div style="z-index:100000" class="modal fade" id="imageUpload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
    	<form id="media-form" action="/upload-media" method="post" enctype="multipart/form-data">
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
	                <button type="button" class="btn btn-primary" data-dismiss="modal" id="insertImage">Upload File</button>
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	            </div><!-- modal-footer -->
	        </div><!-- modal-content -->
        </form>
    </div><!-- modal-dialog -->
</div>

<!-- media library -->
<div ng-app="app" style="z-index:100000" class="modal fade" id="mediaLibrary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div ng-controller="MediaController" class="modal-dialog modal-lg">
    	<form id="media-form" action="/upload-media" method="post" enctype="multipart/form-data">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal">
	                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
	                </button>
	                <h4 class="modal-title" id="myModalLabel">Image Library</h4>
	            </div>
	            <div class="modal-body">
                    <div class="form-group">
                    	@include('_helpers.media-library')
                    </div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="chooseImage()">Insert File</button>
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	            </div><!-- modal-footer -->
	        </div><!-- modal-content -->
        </form>
    </div><!-- modal-dialog -->
</div>
@section('scripts2')
	<script>
	
		// upload attachment through AJAX
	    $("body").on("click", "#insertImage", function(e, data){
	    	e.preventDefault();
	    	file = ($('#media:file'))[0].files[0];
	        var form_data = new FormData();
	        form_data.append('media', file);
	        form_data.append('ajax', 1);
	        $.ajax({
	            type: "post",
	            url: "/upload-media",
	            data: form_data,
	            success: function(response) {
	            	console.log(response);
	                $(".mce-combobox.mce-last.mce-abs-layout-item input.mce-textbox.mce-placeholder").attr("value", response.url);
	            },
	            cache: false,
	            contentType: false,
	            processData: false
	        });           
	    });
	    
	</script>
@stop