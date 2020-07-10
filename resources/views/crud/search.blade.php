@extends('master')

@section('header')
<div class="row mb-2">
	<div class="col-sm-6">
		<h1>Pencarian dengan tags : {{$key}}</h1>
	</div>
</div>
@endsection

@section('content')
@foreach ($question as $item)
<div class="card card-primary card-outline">
	<div class="card-header">
		<a href="/jawaban/{{$item->id_question}}">{{$item->title}}</a>
	</div>
	<div class="card-body">
		<div class="user-block">
			
		<p>{!! $item->description !!}</p>

		@foreach (explode(" ",$item->tags) as $tag)
			<a class="btn btn-sm btn-info mr-1" href="/tags/{{$tag}}">{{ $tag }}</a>
		@endforeach
		</div>


	</div>
</div>
@endforeach
@endsection

