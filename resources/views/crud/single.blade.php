@extends('master')

@push('script-head')
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@endpush

@section('header')
<div class="row mb-2">
	<div class="col-sm-6">
		<h3>{{$data['question']->title}}</h3>
	</div>

</div>
@endsection

@section('content')
<!-- /.pertanyaan -->
<div class="card card-widget">
	<div class="card-header">
		<div class="user-block">
			<img class="img-circle" src="{{asset('/adminlte/dist/img/user1-128x128.jpg')}}" alt="User Image">
			<span class="username"><a>
					@if($data['question']->id == $data['id'])
					Me
					@else
					{{$data['question']->name}}
					@endif</a></span>
			<span class="description"><i class="nav-icon far fa-calendar-alt"></i> {{$data['question']->created_at}} - (last edited : {{$data['question']->updated_at}})</span>
		</div>
		<!-- /.user-block -->
		<div class="card-tools">
			<h3 class="m-1 mr-2 text-muted">{{$data['question']->point}} POIN</h3>
		</div>
		<!-- /.card-tools -->
	</div>
	<!-- /.card-header -->
	<div class="card-body">
		<!-- post text -->
		{!! $data['question']->description !!}

		<i>tags :</i>
		@foreach ($data['question']->tags as $tag)
		<a class="btn btn-sm btn-info mr-1 mt-1" href="/tags/{{$tag}}">{{ $tag }}</a>
		@endforeach

		@if ($data['id'] != $data['question']->id)
		<form action="/pertanyaan/{{$data['question']->id_question}}/vote" method="POST">	
			<span class="float-right">
				@csrf
				@method('PUT')
				<input type="hidden" name="id" value="{{$data['question']->id}}">

				@if ($data['voted_question'] == 0 || $data['voted_question'] == 2)
					<button type="submit" class="btn btn-sm btn-outline-success ml-2" name="val" value="up"><span class="text-sm mr-1">{{$data['like']}}</span>| <i class="far fa-thumbs-up mr-1 ml-1"></i> Like</button>
				@else
					<button type="submit" class="btn btn-sm btn-success ml-2" name="val" value="clear_like"><span class="text-sm mr-1">{{$data['like']}}</span>| <i class="far fa-thumbs-up mr-1 ml-1"></i> Liked</button>
				@endif
				

				@if ($data['point'] < 15)
					<button class="btn btn-sm btn-outline-danger text-sm ml-2" name="val" value="down" disabled=""><span class="text-sm mr-1">{{$data['dislike']}}</span>| <i class="far fa-thumbs-down mr-1 ml-1"></i> Dislike</button>
				@else
					@if ($data['voted_question'] == 1 || $data['voted_question'] == 2)
						<button type="submit" class="btn btn-sm btn-outline-danger text-sm ml-2" name="val" value="down"><span class="text-sm mr-1">{{$data['dislike']}}</span>| <i class="far fa-thumbs-down mr-1 ml-1"></i> Dislike</button>
					@else
						<button type="submit" class="btn btn-sm btn-danger text-sm ml-2" name="val" value="clear_dislike"><span class="text-sm mr-1">{{$data['dislike']}}</span>| <i class="far fa-thumbs-down mr-1 ml-1"></i> Disliked</button>
					@endif
					
				@endif
			</span>
		</form>
		@else
		<span class="float-right">
			<button class="btn btn-sm btn-outline-success text-sm ml-2" disabled=""><span class="text-sm mr-1">{{$data['like']}}</span>| <i class="far fa-thumbs-up mr-1 ml-1"></i> Like</button>

			<button class="btn btn-sm btn-outline-danger text-sm ml-2" disabled=""><span class="text-sm mr-1">{{$data['dislike']}}</span>| <i class="far fa-thumbs-down mr-1 ml-1"></i> Dislike</button>
		</span>

		@endif
		<!-- <span class="float-right text-muted">45 likes - 2 comments</span> --> 
	</div>
	<!-- /.card-body -->
	<div class="card-footer card-comments">
		<!-- Komentar Pertanyaan -->
		@foreach ($data['comment_question'] as $cq)	
		<div class="card-comment">
			<!-- User image -->
			<img class="img-circle img-sm" src="{{asset('/adminlte/dist/img/user3-128x128.jpg')}}" alt="User Image">
			<div class="comment-text">
				<span class="username">
					@if($cq->id == $data['id'])
					Me
					@else
					{{$cq->name}}
					@endif

					<span class="text-muted float-right">{{$cq->created_at}}</span>
				</span><!-- /.username -->
				{!! $cq->content !!}

				@if($cq->id == $data['id'])
				<form action="/komentar/pertanyaan/destroy" method="POST" style="display: inline" >
					@csrf
					@method('DELETE')
					<input type="hidden" name="id_comment" value="{{$cq->id_comment}}">
					<input type="hidden" name="id_question" value="{{$cq->id_question}}">
					<button type="submit" class="btn btn-sm float-right" onclick="return confirm('Anda yakin?')"><i class="fa fa-trash"></i></button>
				</form>
				@endif
			</div>
			<!-- /.comment-text -->
		</div>
		@endforeach
		<!-- /.card-comment -->
	</div>
	<!-- /.card-footer -->
	<div class="card-footer">
		<form action="/komentar/pertanyaan/{{$data['question']->id_question}}" method="POST">
			<img class="img-fluid img-circle img-sm" src="{{asset('/adminlte/dist/img/user4-128x128.jpg')}}" alt="Alt Text">
			<div class="img-push">
				@csrf
				@method('PUT')
				<input type="text" class="form-control form-control-sm" name="content" placeholder="Masukkan komentar">
			</div>	
		</form>
	</div>
	<!-- /.card-footer -->
</div>
<!-- /.pertanyaan -->

<label for="description">Jawaban ({{$data['count']}})</label>

<!-- /.jawaban -->
@foreach ($data['answer'] as $item)
<div class="card card-widget">
	<div class="card-header">
		<div class="user-block">
			<img class="img-circle" src="{{asset('/adminlte/dist/img/user1-128x128.jpg')}}" alt="User Image">
			<span class="username"><a>
					@if($item->id == $data['id'])
					Me
					@else
					{{$item->name}}
					@endif</a></span>
			<span class="description"><i class="nav-icon far fa-calendar-alt"></i> {{$item->created_at}} - (last edited : {{$item->updated_at}})</span>	
		</div>
		<!-- /.user-block -->
		<div class="card-tools">
			<h3 class="m-1 mr-2 text-muted green">{{$item->point}} POIN</h3>
		</div>
		<!-- /.card-tools -->
	</div>
	<!-- /.card-header -->
	<div class="card-body">
		<!-- post text -->
		{!! $item->description !!}

		@if($item->best_answer == 1)
			<i>&#10004;</i> - Terpilih sebagai jawaban terbaik
		@endif

		<!-- tombol like dll -->
		<div>
			@if($data['id'] != $item->id)
				<span class="float-right mb-2">

					<!-- best answer -->
					<?php if (empty($data['best_answer'])) { 
						if ($data['id'] == $data['question']->id) { ?>
							<form action="/jawaban/{{$item->id_answer}}/best" method="POST" class="float-right mb-2">
								@csrf
								@method('PUT')
								<input type="hidden" name="best" value="1">
								<!-- Untuk reputation point -->
								<input type="hidden" name="id" value="{{$item->id}}">
								<input type="hidden" name="id_question" value="{{$data['question']->id_question}}">
								<input type="hidden" name="val" value="up">
								<button type="submit" class="btn btn-sm btn-outline-success text-sm ml-2"><span class="text-sm mr-1"> jadikan jawaban terbaik</span></button>
							</form>
						
					<?php }}else{
						if ($item->best_answer == 1) { 
							if ($data['id'] == $data['question']->id) { ?>
							<form action="/jawaban/{{$item->id_answer}}/best" method="POST" class="float-right mb-2">
								@csrf
								@method('PUT')
								<input type="hidden" name="best" value="0">
								<!-- Untuk reputation point -->
								<input type="hidden" name="id" value="{{$item->id}}">
								<input type="hidden" name="id_question" value="{{$data['question']->id_question}}">
								<input type="hidden" name="val" value="down">
								<button type="submit" class="btn btn-sm btn-outline-danger text-sm ml-2"><span class="text-sm mr-1">batalkan jawaban terbaik</span></button>
							</form>
							<?php }else {?>
								<button class="btn btn-sm  btn-success text-sm ml-2"><span class="text-sm mr-1">terpilih sebagai jawaban terbaik</span></button>
							
					<?php }}}?>

					<form action="/jawaban/{{$item->id_answer}}/vote" method="POST" class="float-right mb-2">
						@csrf
						@method('PUT')
						<input type="hidden" name="id" value="{{$item->id}}">
						<input type="hidden" name="id_q" value="{{$data['question']->id_question}}">

						<button type="submit" class="btn btn-sm btn-outline-success text-sm ml-2" name="val" value="up"><span class="text-sm mr-1">{{$item->like}}</span>| <i class="far fa-thumbs-up mr-1 ml-1"></i> Like</button>

						@if($data['point'] < 15)
							<button class="btn btn-sm btn-outline-danger text-sm ml-2" name="val" value="down" disabled=""><span class="text-sm mr-1">{{$item->dislike}}</span>| <i class="far fa-thumbs-down mr-1 ml-1"></i> Dislike</button>
						@else
							<button type="submit" class="btn btn-sm btn-outline-danger text-sm ml-2" name="val" value="down"><span class="text-sm mr-1">{{$item->dislike}}</span>| <i class="far fa-thumbs-down mr-1 ml-1"></i> Dislike</button>
						@endif
					</form>
				</span>
			@else
				<span class="float-right">
					<a href="/jawaban/{{$item->id_answer}}/edit" class="btn btn-sm btn-warning text-sm ml-2"><i class="fas fa-edit mr-1 ml-1"></i> <span class="text-sm mr-1"> Edit</span></a>
					<button class="btn btn-sm btn-outline-success text-sm ml-2" disabled=""><i class="far fa-thumbs-up mr-1 ml-1"></i> <span class="text-sm mr-1">{{$item->like}}</span></button>

					<button class="btn btn-sm btn-outline-danger text-sm ml-2" disabled=""><i class="far fa-thumbs-down mr-1 ml-1"></i> <span class="text-sm mr-1">{{$item->dislike}}</span></button>
				</span>

				<form action="/jawaban/{{$item->id_answer}}" method="POST" style="display: inline" class="float-right">
					@csrf
					@method('DELETE')
					<input type="hidden" name="id_question" value="{{$data['question']->id_question}}">
					<button type="submit" class="btn btn-sm btn-danger text-sm ml-2" onclick="return confirm('Anda yakin ?')"> <i class="fas fa fa-trash"></i> Hapus</button>
				</form>
			@endif
		</div>
					
	</div>
	<!-- /.card-body -->
	<div class="card-footer card-comments">

		<!-- Komentar Jawaban -->
		@foreach ($data['comment_answer'] as $ca)
		@if($ca->id_answer == $item->id_answer)	
		<div class="card-comment">
			<!-- User image -->
			<img class="img-circle img-sm" src="{{asset('/adminlte/dist/img/user3-128x128.jpg')}}" alt="User Image">
			<div class="comment-text">
				<span class="username">
					@if($ca->id == $data['id'])
						Me
					@else
						{{$ca->name}}
					@endif

					<span class="text-muted float-right">{{$ca->created_at}}</span>
				</span><!-- /.username -->
				 {!! $ca->content !!} 

				@if($ca->id == $data['id'])
				<form action="/komentar/pertanyaan/destroy" method="POST" style="display: inline" >
					@csrf
					@method('DELETE')
					<input type="hidden" name="id_comment" value="{{$cq->id_comment}}">
					<input type="hidden" name="id_question" value="{{$cq->id_question}}">
					<button type="submit" class="btn btn-sm float-right" onclick="return confirm('Anda yakin?')"><i class="fa fa-trash"></i></button>
				</form>
				@endif
			</div>
			<!-- /.comment-text -->
		</div>
		@endif
		@endforeach
	</div>
	<!-- /.card-footer -->
	<div class="card-footer">
		<form action="/komentar/jawaban/{{$item->id_answer}}" method="POST">
			<img class="img-fluid img-circle img-sm" src="{{asset('/adminlte/dist/img/user4-128x128.jpg')}}" alt="Alt Text">
			<div class="img-push">
				@csrf
				@method('PUT')
				<input type="hidden" name="id_answer" value="{{$item->id_answer}}">
				<input type="hidden" name="id_question" value="{{$item->id_question}}">
				<input type="text" class="form-control form-control-sm" name="content" placeholder="Masukkan komentar">
			</div>	
		</form>
	</div>
	<!-- /.card-footer -->
</div>
@endforeach
<!-- /.jawaban -->

@if($data['id'] != $data['question']->id)
<!-- Penulis tidak bisa menjawab pertanyaan sendiri -->
<div class="card card-outline">
	<div class="card-body">
		<div class="post">
			<form action="/jawaban/{{$data['question']->id_question}}" method="POST">
				@csrf
				<div class="form-group">
					<label for="description">Berikan jawaban anda :</label>
					<textarea id="description" name="description" class="form-control my-editor">{!! old('description', $description ?? '') !!}</textarea>
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div>
</div>
@endif

<!-- /.card -->
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