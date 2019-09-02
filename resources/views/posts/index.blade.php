@extends('master')

@section('content')
<div class="row">
	<div class="col-md-12">
		@foreach($posts as $post)
		<h1><a href="{{ route('posts.single', ['slug' => $post->slug]) }}">{{$post->title}}</a></h1>
		<hr />
		@endforeach
	</div>
</div>
@endsection
