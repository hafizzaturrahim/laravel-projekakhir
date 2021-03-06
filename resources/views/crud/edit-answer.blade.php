@extends('master')

@push('script-head')
	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@endpush

@section('content')
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Edit Jawaban</h3>
	</div>
	<!-- /.card-header -->
	<div class="card-body">
		<form action="{{url('/jawaban/'.$answer->id_answer)}}" method="POST">
			@csrf
			@method('PUT')
			<div class="form-group">
				<label for="description"> Jawaban :</label>
        <input type="hidden" name="id_question" value="{{$answer->id_question}}">
				<textarea name="description" class="form-control my-editor">{!! old('description', $answer->description ?? '') !!}</textarea>
			</div>
			<button type="submit" class="btn btn-primary">Simpan</button>
		</form>
	</div>
	<!-- /.card-body -->
</div>

@endsection

@push('scripts')
<script>
  var editor_config = {
    path_absolute : "/",
    selector: "textarea.my-editor",
    plugins: [
      "advlist autolink lists link image charmap print preview hr anchor pagebreak",
      "searchreplace wordcount visualblocks visualchars code fullscreen",
      "insertdatetime media nonbreaking save table contextmenu directionality",
      "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    relative_urls: false,
    file_browser_callback : function(field_name, url, type, win) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
      if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no"
      });
    }
  };

  tinymce.init(editor_config);
</script>
@endpush