@extends('master')

@section('header')
<div class="row mb-2">
	<div class="col-sm-6">
		<h1>Pencarian dengan tags : {{$key}}</h1>
	</div>
</div>
@endsection

@section('content')
<div class="card">
	<!-- /.card-header -->
	<div class="card-body p-0">
		<table id="example1" class="table table-striped">
			<thead>
				<tr>
					<th>No.</th>
					<th width="40%">Pertanyaan</th>
					<th>Pembuat</th>
					<th>Jumlah Jawaban</th>
					<th width="20%">Tags</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($question as $item)
				<tr>
					<td>{{$loop->iteration}} </td>
					<td>
						<a href="/jawaban/{{$item->id_question}} ">{{ $item->title }}</a>
						<span class="description">{!! $item->description !!}</span>
					</td>
					<td>
						<div class="user-block">
							<img class="img-circle" src="{{asset('/adminlte/dist/img/user1-128x128.jpg')}}" alt="User Image">
							<span class="username"><a>{{$item->name}}</a></span>
							<span class="description"><i class="nav-icon far fa-calendar-alt"></i> {{ $item->created_at }}</span>
						</div>
					</td>
					<td class="text-center"><h4>{{ $item->jumlah_jawaban }}</h4></td>
					<td>
						@foreach (explode(" ",$item->tags) as $tag)
							<a class="btn btn-sm btn-info m-1" href="/tags/{{$tag}}">{{ $tag }}</a>
						@endforeach
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<!-- /.card-body -->
</div>
@endsection

