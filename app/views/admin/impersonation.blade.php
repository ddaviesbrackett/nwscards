@extends('layout')

@section('title')
	Impersonate
@stop

@section('head-extra')
@stop

@section('content')
<div class="masthead">
	<h1>Become Someone Else</h1>
	<p>Click Impersonate to become another user</p>
</div>
<div class="container-fluid">
	<p>
		<br/>	
		Impersonation allows you <em>to act as another user in every way</em> - see and change their order, see their order history, etc.
		<b>Be sure you want to do this before you do it, and stop impersonating them as soon as you're done.</b>
	</p>
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