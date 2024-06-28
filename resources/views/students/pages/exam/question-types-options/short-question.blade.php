<div class="row answer-padding">
	<div class="col-md-12 mb-2" data-id="data_{{ $key+1 }}_1">
		<textarea class="form-control short-question" id="short-question_{{ $key+1 }}"  name="correctAnswer_{{ $key+1 }}_1"></textarea>
		<hr>
		<button type="button" class="uploadFileBtn btn btn-outline-primary btn-sm"><i class="fa fa-plus"></i> Add Image or PDF</button>
		<form action="#" method="post" enctype="multipart/form-data" class="uploadFileForm">
			<input type="file" name="file[]" class="d-none uploadFileInput" accept=".doc, .docx, .pdf, .jpeg, .jpg, .xls, .png" multiple>
		</form>
	</div>
	<hr class="mt-2">
	<div class="col-sm-12">
		<div class="uploaded-file-block mt-2">
        	<ul class="uploaded-doc putURLImageHere" style="max-height: -1px !important;"></ul>
        </div>
	</div>
</div>