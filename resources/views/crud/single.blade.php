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
					<a href="#">Jonathan Burke Jr.</a>
				</span>
				<span class="description"> <i class="nav-icon far fa-calendar-alt"></i> {{$data['question']->created_at}}  <i> (last edited : {{$data['question']->updated_at}})</i></span>
			</div>
			<!-- /.user-block -->
			<p>
				{{$data['question']->description}}
			</p>
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
		<div class="post">
			<div class="user-block">
				<img class="img-circle img-bordered-sm" src="{{ asset('/adminlte/dist/img/user4-128x128.jpg') }}" alt="user image">
				<span class="username">
					<a href="#">Jonathan Burke Jr.</a>
				</span>
				<span class="description"><i class="nav-icon far fa-calendar-alt"></i> {{$item->created_at}}  <i> (last edited : {{$item->updated_at}})</i></span>
			</div>
			<!-- /.user-block -->
			<p>
				{{$item->description}}
			</p>
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