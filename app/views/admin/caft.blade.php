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

@foreach($model as $name => $bucket)
	<h2>{{{$name}}}</h2>
	<table class='table'>
		<tr>
			<th>Account</th>
			<th>Institution</th>
			<th>Transit</th>
			<th>Name</th>
			<th>Amount</th>
			<th>Frequency</th>
		</tr>
		@foreach($bucket as $info)
			<tr>
				<td>{{{$info['acct']}}}</td>
				<td>{{{$info['institution']}}}</td>
				<td>{{{$info['transit']}}}</td>
				<td>{{{$info['user']->name}}}</td>
				<td>{{{$info['user']->coop + $info['user']->saveon}}}00</td>
				<td>{{{$info['user']->schedule}}}</td>
			</tr>
		@endforeach
	</table>
@endforeach
<p>
	Total rows: {{{count($model)}}}
</p>
<p>
	Total amount: {{{$total}}}00
</p>
</div>
@stop