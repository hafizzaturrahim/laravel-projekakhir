@extends('master')

@section('content')
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Edit Pertanyaan</h3>
	</div>
	<!-- /.card-header -->
	<div class="card-body">
		<form action="{{url('/pertanyaan/'.$question->id_question)}}" method="POST">
			@csrf
			@method('PUT')
			<div class="form-group">
				<label for="title">Judul Pertanyaan :</label>
				<input type="text" class="form-control" id="title" name="title" value="{{$question->title}}">
			</div>
			<div class="form-group">
				<label for="description">Isi Pertanyaan :</label>
				<textarea class="form-control" id="description" name="description" rows="3">{{$question->description}}</textarea>
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
	</div>
	<!-- /.card-body -->
</div>

@endsection