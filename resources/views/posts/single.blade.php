@extends('master')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h1>{{$page->title}}</h1>
		{!!$page->body!!}
	</div>
</div>
@endsection
