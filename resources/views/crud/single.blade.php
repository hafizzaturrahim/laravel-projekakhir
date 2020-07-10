@extends('master')

@push('script-head')
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@endpush

@section('header')
<div class="row mb-2">
	<div class="col-sm-6">
		<h1>{{$data['question']->title}}</h1>
	</div>
	<div class="col-sm-6">
		<ol class="breadcrumb float-right">
			<a class="btn btn-primary" href="/pertanyaan">Daftar Pertanyaan</a>
		</ol>
	</div>
</div>
@endsection

@section('content')
<div class="card card-primary card-outline">
	<div class="card-body">
		<!-- Post -->
		<div class="post">
			<div class="user-block">
				<img class="img-circle img-bordered-sm" src="{{ asset('/adminlte/dist/img/user4-128x128.jpg') }}" alt="user image">
				<span class="username">
					<a href="#">{{$data['question']->name}}</a>
					<a href="#">Reputation Point : {{$data['question']->point}} </a>
				</span>
				<span class="description"> <i class="nav-icon far fa-calendar-alt"></i> {{$data['question']->created_at}}  <i> (last edited : {{$data['question']->updated_at}})</i></span>
			</div>
			<!-- /.user-block -->
			<p>
				{!! $data['question']->description !!}
			</p>
			
			@foreach ($data['question']->tags as $tag)
			<a class="btn btn-sm btn-info mr-1" href="/tags/{{$tag}}">{{ $tag }}</a>
			@endforeach

			@if ($data['id'] != $data['question']->id)
			<form action="/pertanyaan/{{$data['question']->id_question}}/vote" method="POST">
				<p>
					<span class="float-right mb-2">
						@csrf
						@method('PUT')
						<input type="hidden" name="id" value="{{$data['question']->id}}">
						<button type="submit" class="btn btn-outline-success text-sm ml-2" name="val" value="up"><span class="text-sm mr-1">{{$data['like']}}</span>| <i class="far fa-thumbs-up mr-1 ml-1"></i> Like</button>

						@if ($data['point'] < 15)
						<button class="btn btn-outline-danger text-sm ml-2" name="val" value="down" disabled=""><span class="text-sm mr-1">{{$data['dislike']}}</span>| <i class="far fa-thumbs-down mr-1 ml-1"></i> Dislike</button>
						@else
						<button type="submit" class="btn btn-outline-danger text-sm ml-2" name="val" value="down"><span class="text-sm mr-1">{{$data['dislike']}}</span>| <i class="far fa-thumbs-down mr-1 ml-1"></i> Dislike</button>
						@endif
					</span>
				</p>
			</form>
			@else
			<p>
				<span class="float-right">
					<button class="btn btn-outline-success text-sm ml-2" disabled=""><span class="text-sm mr-1">{{$data['like']}}</span>| <i class="far fa-thumbs-up mr-1 ml-1"></i> Like</button>

					<button class="btn btn-outline-danger text-sm ml-2" disabled=""><span class="text-sm mr-1">{{$data['dislike']}}</span>| <i class="far fa-thumbs-down mr-1 ml-1"></i> Dislike</button>
				</span>
			</p>
			@endif

			<!-- Komentar Pertanyaan -->
			@foreach ($data['comment_question'] as $cq)
			<div class="clearfix m-0">
				<div class="user-block m-0">
					<a href="#">ID User : {{$cq->id}} </a>
					<span> {!! $cq->content !!} </span>
					<span class="description" style="display: inline;"><i class="nav-icon far fa-calendar-alt"></i> <i>{{$cq->created_at}}</i></span>
				</div>
			</div>
			@endforeach

			<div class="post mt-2">
				<form action="/komentar/pertanyaan/{{$data['question']->id_question}}" method="POST">
					@csrf
					@method('PUT')
					<div class="form-group mb-0">
						<input type="text" class="form-control" name="content" placeholder="Masukkan komentar">
					</div>
				</form>
			</div>
			
		</div>
		<!-- /.post -->		
	</div><!-- /.card-body -->
</div>

<div class="card card-outline">
	<div class="card-header">
		<label for="description">Jawaban ({{$data['count']}})</label>
	</div>
	<div class="card-body">
		<!-- Post -->
		@foreach ($data['answer'] as $item)
		<div class="post clearfix">
			<div class="user-block">
				<img class="img-circle img-bordered-sm" src="{{ asset('/adminlte/dist/img/user4-128x128.jpg') }}" alt="user image">
				<span class="username">
					<a href="#">{{$item->name}} </a>
					<a href="#">Reputation Point : {{$item->point}} </a>

				</span>
				<span class="description"><i class="nav-icon far fa-calendar-alt"></i> {{$item->created_at}}  <i> (last edited : {{$item->updated_at}})</i></span>
			</div>
			<!-- /.user-block -->
			<p>
				{!! $item->description !!} 
			</p>
			@if($data['id'] != $item->id)
			<p>
				<span class="float-right mb-2">
					<?php if (empty($data['best_answer'])) { 
						if ($data['id'] == $data['question']->id) { ?>
							<form action="/jawaban/{{$item->id_answer}}/best" method="POST" class="float-right mb-2">
								@csrf
								@method('PUT')
								<input type="hidden" name="best" value="1">
								<input type="hidden" name="id_question" value="{{$data['question']->id_question}}">
								<button type="submit" class="btn btn-outline-success text-sm ml-2"><span class="text-sm mr-1"> jadikan jawaban terbaik</span></button>
							</form>
						
					<?php }}else{
						if ($item->best_answer == 1) { ?>
							<form action="/jawaban/{{$item->id_answer}}/best" method="POST" class="float-right mb-2">
								@csrf
								@method('PUT')
								<input type="hidden" name="best" value="0">
								<input type="hidden" name="id_question" value="{{$data['question']->id_question}}">
								<button type="submit" class="btn btn-success text-sm ml-2"><span class="text-sm mr-1">jawaban terbaik</span></button>
							</form>
							
						<?php }}?>
					

					<form action="/jawaban/{{$item->id_answer}}/vote" method="POST" class="float-right mb-2">
						@csrf
						@method('PUT')
						<input type="hidden" name="id" value="{{$item->id}}">
						<input type="hidden" name="id_q" value="{{$data['question']->id_question}}">

						<button type="submit" class="btn btn-outline-success text-sm ml-2" name="val" value="up"><span class="text-sm mr-1">{{$item->like}}</span>| <i class="far fa-thumbs-up mr-1 ml-1"></i> Like</button>

						@if($data['point'] < 15)
						<button class="btn btn-outline-danger text-sm ml-2" name="val" value="down" disabled=""><span class="text-sm mr-1">{{$item->dislike}}</span>| <i class="far fa-thumbs-down mr-1 ml-1"></i> Dislike</button>
						@else
						<button type="submit" class="btn btn-outline-danger text-sm ml-2" name="val" value="down"><span class="text-sm mr-1">{{$item->dislike}}</span>| <i class="far fa-thumbs-down mr-1 ml-1"></i> Dislike</button>
						@endif
					</form>
				</span>
			</p>
			@else
			<p>
				<span class="float-right">
					<a href="/jawaban/{{$item->id_answer}}/edit"  class="btn btn-warning text-sm ml-2"><span class="text-sm mr-1"> Edit</span></a>
					<button class="btn btn-outline-success text-sm ml-2" disabled=""><i class="far fa-thumbs-up mr-1 ml-1"></i> <span class="text-sm mr-1">{{$item->like}}</span></button>

					<button class="btn btn-outline-danger text-sm ml-2" disabled=""><i class="far fa-thumbs-down mr-1 ml-1"></i> <span class="text-sm mr-1">{{$item->dislike}}</span></button>
				</span>

				<form action="/jawaban/{{$item->id_answer}}" method="POST" style="display: inline" class="float-right">
					@csrf
					@method('DELETE')
					<button type="submit" class="btn btn-danger text-sm ml-2" onclick="return confirm('Anda yakin ?')"> <i class="fas fa fa-trash"></i> Hapus</button>
				</form>
			</p>
			@endif
		</div>
		@endforeach
		<!-- /.post -->		
	</div><!-- /.card-body -->
</div>
<!-- /.card -->

<div class="card card-outline">
	<div class="card-body">
		<!-- Post -->
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
		<!-- /.post -->		
		<!-- /.tab-content -->
	</div><!-- /.card-body -->
</div>
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