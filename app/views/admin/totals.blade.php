@extends('layout')

@section('title')
	Totals
@stop

@section('head-extra')
@stop

@section('content')
<div class="masthead">
	<h1>Totals</h1>
</div>
<div class="container-fluid text-center">
<h2>Total users: {{{$totalUsers}}}</h2>
<h2>Cards by store and order frequency</h2>
<p>Note: Monthly totals include bi-weekly totals.</p>
<table class='table text-left'>
	<tr>
		<th>frequency</th>
		<th>Save-On</th>
		<th>Kootenay Co-op</th>
	</tr>
	<tr>
		<td>Monthly</td>
		<td>{{{$monthly['saveon'] + $biweekly['saveon']}}}</td>
		<td>{{{$monthly['coop'] + $biweekly['coop']}}}</td>
	</tr>
	<tr>
		<td>Monthly (second) </td>
		<td>{{{$monthlySecond['saveon'] + $biweekly['saveon']}}}</td>
		<td>{{{$monthlySecond['coop'] + $biweekly['coop']}}}</td>
	</tr>
	<tr>
		<td>Bi-weekly</td>
		<td>{{{$biweekly['saveon']}}}</td>
		<td>{{{$biweekly['coop']}}}</td>
	</tr>
</table>

<h2>Users by class</h2>
<p>Note: Some users support more than one class, so these don't add up to the total order amounts.</p>
<table class='table text-left'>
	<tr>
		<th>Class</th>
		<th>Users Supporting</th>
	</tr>
	@foreach($classes as $class => $total)
		<tr>
			<td>{{{$class}}}</td>
			<td>{{{$total}}}</td>
		</tr>
	@endforeach
</table>
</div>
@stop