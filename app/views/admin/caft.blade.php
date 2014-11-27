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
<?php $totalRows = 0;?>
@foreach($model as $name => $bucket)
<?php $totalRows += count($bucket);?>
	<h2>{{{$name}}}</h2>
	<table class='table'>
		<tr>
			<th>Account</th>
			<th>Institution</th>
			<th>Transit</th>
			<th>Name</th>
			<th>Amount</th>
			<th>Frequency</th>
			<th>Has One-Time Order?</th>
		</tr>
		@foreach($bucket as $info)
			<tr>
				<td>{{{$info['acct']}}}</td>
				<td>{{{$info['institution']}}}</td>
				<td>{{{$info['transit']}}}</td>
				<td>{{{$info['order']->user->name}}}</td>
				<td>${{{$info['order']->totalCards()}}}00</td>
				<td>{{{$info['order']->user->schedule}}}</td>
				<td>{{{$info['order']->hasOnetime()?'YES':''}}}</td>
			</tr>
		@endforeach
	</table>
@endforeach
<p>
	Total rows: {{{$totalRows}}}
</p>
<p>
	Total amount: {{{$total}}}00
</p>
</div>
@stop