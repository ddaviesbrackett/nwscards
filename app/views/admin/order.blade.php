@extends('layout')
@section('title')
	Order Sheets
@stop

@section('head-extra')
<style>
	h1 {margin-top:0;}
</style>
@stop

@section('content')
<div class="masthead">
	<h1>Card Pickup Sheet</h1>
</div>
<div class="container-fluid">
<table class='table'>
	<tr>
		<th style="width:25%;">Name <br/>(Alternate)</th>
		<th style="width:12%;">Save-On</th>
		<th style="width:12%;">Co-op</th>
		<th style="width:51%;">Signature</th>
	</tr>
	@foreach($pickup as $order)
		<tr>
			<td>
				{{{$order->user->name}}}<br/>
				({{{$order->user->pickupalt or 'none'}}})<br/>
			</td>
			<td>{{{$order->saveon}}}</td>
			<td>{{{$order->coop}}}</td>
			<td style="border-bottom:1px solid #000;"></td>
		</tr>
	@endforeach
</table>
</div>
<div class="masthead" style="page-break-before:always;">
	<h1>Card Mailing Sheet</h1>
</div>
<div class="container-fluid">
<table class='table'>
	<tr>
		<th style="width:25%;">Name</th>
		<th style="width:51%;">Address</th>
		<th style="width:12%;">Save-On</th>
		<th style="width:12%;">Co-op</th>
	</tr>
	@foreach($mail as $order)
		<tr>
			<td>{{{$order->user->name}}} ({{{$order->user->getPhone()}}})</td>
			<td>{{{$order->user->address()}}}</td>
			<td>{{{$order->saveon}}}</td>
			<td>{{{$order->coop}}}</td>
		</tr>
	@endforeach
</table>
</div>
@stop