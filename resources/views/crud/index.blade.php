@extends('master')

@section('header')
<div class="row mb-2">
	<div class="col-sm-6">
		<h1>Daftar Pertanyaan</h1>
	</div>
	<div class="col-sm-6">
		<ol class="breadcrumb float-right">
			<a class="btn btn-success" href="/pertanyaan/create">Buat Pertanyaan</a>
		</ol>
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
					<th class="text-center">Jumlah Jawaban</th>
					<th>Actions</th>
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
						<a class="btn btn-sm btn-primary mr-2" href="/jawaban/{{$item->id_question}}">Show</a>
						@if ($item->id == $id_user)
						<a class="btn btn-sm btn-warning mr-2" href="/pertanyaan/{{$item->id_question}}/edit">Edit</a>
						<form action="/pertanyaan/{{$item->id_question}}" method="POST" style="display: inline;">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ?')"> <i class="fas fa fa-trash"></i></button>
						</form>
						@endif
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<!-- /.card-body -->
</div>
@endsection