@extends('layout.landing_page.app')
@section('content')
	<div class="container">
		<h1>Directory Listing</h1>
		<p>We give opportunitites for our students to find good schools and universities all over the world.<br>Register your institution with us today!</p>
		@if (count($directories) > 0)
			<table class="table table-bordered">
				<tr>
					<th>name</th>
					<th>level</th>
					<th>description</th>
					<th>url</th>
					<th>phone</th>
					<th>email</th>
					<th>logo</th>
					<th>verified</th>
				</tr>
				@foreach ($directories as $directory)
					<tr>
						<td>{{ $directory->name }}</td>
						<td>{{ $directory->level }}</td>
						<td>{{ $directory->description }}</td>
						<td><a href="https://{{$directory->url}}" target="_blank">{{ $directory->url }}</a></td>
						<td>{{ $directory->phone }}</td>
						<td><a href="mailto:{{ $directory->email }}">{{ $directory->email }}</td>
						<td><img src="{{ asset('/storage/directory/images/' . $directory->logo) }}"></td>
						@if ($directory->isVerified == 0)
							<td>No</td>
						@else
							<td>Yes</td>
						@endif
					</tr>	
				@endforeach
			</table>
		@else
			<p class="text-info">No listings yet. Be the first to post your institution.</p>
		@endif
		<a href="{{ route('directory.create') }}" class="btn btn-primary">Add listing</a>
	</div>
@endsection