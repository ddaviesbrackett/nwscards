@extends('layout')

@section('title')
	CAFT entry form
@stop

@section('head-extra')
@stop

@section('content')
<div class="masthead">
	<h1>CAFT entry form</h1>
</div>
<div class="container-fluid">
<table class='table'>
	<tr>
		<th>Account</th>
		<th>Transit</th>
		<th>Institution</th>
		<th>Name</th>
		<th>Amount</th>
		<th>Frequency</th>
	</tr>
	@foreach($model as $info)
		<tr>
			<td>{{{$info['acct']}}}</td>
			<td>{{{$info['transit']}}}</td>
			<td>{{{$info['institution']}}}</td>
			<td>{{{$info['user']->name}}}</td>
			<td>{{{$info['user']->coop + $info['user']->saveon}}}00</td>
			<td>{{{$info['user']->schedule}}}</td>
		</tr>
	@endforeach
</table>
</div>
@stop