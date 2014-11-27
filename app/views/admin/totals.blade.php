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
<p>Note again:  this is recurring orders *only* - do not use for ordering!  you'll miss the one-time orders!!</p>
<table class='table text-left'>
	<tr>
		<th></th>
		<th>Save-On</th>
		<th>Co-op</th>
	</tr>
	<tr>
		<td>First Order</td>
		<td>{{{$monthly['saveon'] + $biweekly['saveon']}}}</td>
		<td>{{{$monthly['coop'] + $biweekly['coop']}}}</td>
	</tr>
	<tr>
		<td>Second Order </td>
		<td>{{{$monthlySecond['saveon'] + $biweekly['saveon']}}}</td>
		<td>{{{$monthlySecond['coop'] + $biweekly['coop']}}}</td>
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