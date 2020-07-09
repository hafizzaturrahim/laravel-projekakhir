@extends('master')

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
					<a href="#">{{$data['question']->name}} ID User : {{$data['question']->id}}</a>
					<a href="#">Reputation Point : {{$data['question']->point}} </a>
				</span>
				<span class="description"> <i class="nav-icon far fa-calendar-alt"></i> {{$data['question']->created_at}}  <i> (last edited : {{$data['question']->updated_at}})</i></span>
			</div>
			<!-- /.user-block -->
			<p>
				{{$data['question']->description}}
			</p>
			@if ($data['id'] != $data['question']->id)
			<form action="/pertanyaan/{{$data['question']->id_question}}/vote" method="POST">
				<p>
					<span class="float-right">
						@csrf
						@method('PUT')
						<input type="hidden" name="id" value="{{$data['question']->id}}">
						<button type="submit" class="btn btn-outline-success text-sm ml-2" name="val" value="up"><span class="text-sm mr-1">{{$data['like']}}</span>| <i class="far fa-thumbs-up mr-1 ml-1"></i> Like</button>

						@if ($data['count'] < 15)
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
					<a href="#">{{$data['question']->name}} ID User : {{$item->id}} </a>
					<a href="#">Reputation Point : {{$item->point}} </a>
				</span>
				<span class="description"><i class="nav-icon far fa-calendar-alt"></i> {{$item->created_at}}  <i> (last edited : {{$item->updated_at}})</i></span>
			</div>
			<!-- /.user-block -->
			<p>
				{{$item->description}}
			</p>
			@if ($data['id'] != $item->id)
			<form action="/jawaban/{{$item->id_answer}}/vote" method="POST">
				<p>
					<span class="float-right">
						@csrf
						@method('PUT')
						<input type="hidden" name="id" value="{{$item->id}}">
						<input type="hidden" name="id_q" value="{{$data['question']->id_question}}">

						<button type="submit" class="btn btn-outline-success text-sm ml-2" name="val" value="up"><span class="text-sm mr-1">{{$item->like}}</span>| <i class="far fa-thumbs-up mr-1 ml-1"></i> Like</button>
						@if($data['count'] < 15)
						<button class="btn btn-outline-danger text-sm ml-2" name="val" value="down" disabled=""><span class="text-sm mr-1">{{$item->dislike}}</span>| <i class="far fa-thumbs-down mr-1 ml-1"></i> Dislike</button>
						@else
						<button type="submit" class="btn btn-outline-danger text-sm ml-2" name="val" value="down"><span class="text-sm mr-1">{{$item->dislike}}</span>| <i class="far fa-thumbs-down mr-1 ml-1"></i> Dislike</button>
						@endif
					</span>
				</p>
			</form>
			@else
			<p>
				<span class="float-right">
					<button class="btn btn-outline-success text-sm ml-2" disabled=""><i class="far fa-thumbs-up mr-1 ml-1"></i> <span class="text-sm mr-1">{{$item->like}}</span></button>

					<button class="btn btn-outline-danger text-sm ml-2" disabled=""><i class="far fa-thumbs-down mr-1 ml-1"></i> <span class="text-sm mr-1">{{$item->dislike}}</span></button>
				</span>
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
					<textarea class="form-control" id="description" name="description" rows="3"></textarea>
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