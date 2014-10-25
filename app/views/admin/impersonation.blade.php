@extends('layout')

@section('title')
	Impersonate
@stop

@section('head-extra')
@stop

@section('content')
<div class="masthead">
	<h1>Become Someone Else</h1>
</div>
<div class="container-fluid">
	<table class="table">
		<tr>
			<th>Name</th>
			<th></th>
		</tr>
		@foreach( $users as $user)
		<tr>
			<td>{{{$user->name}}}</td>
			<td><a class="btn btn-default" href="/admin/impersonate/{{{$user->id}}}"><span class="glyphicon glyphicon-log-in"></span> Impersonate</a></td>
		</tr>
		@endforeach
</div>
@stop