@extends('layout')
@section('title')
	Order Sheets
@stop

@section('head-extra')
@stop

@section('content')
<div class="masthead">
	<h1>Card Pickup Sheet</h1>
</div>
<div class="container-fluid">
<table class='table'>
	<tr>
		<th style="width:25%;">User</th>
		<th style="width:12%;">Save-On</th>
		<th style="width:12%;">Coop</th>
		<th style="width:51%;">Signature</th>
	</tr>
	@foreach($pickup as $order)
		<tr>
			<td>{{{$order->user->name}}}</td>
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
		<th style="width:25%;">User</th>
		<th style="width:12%;">Save-On</th>
		<th style="width:12%;">Coop</th>
		<th style="width:51%;">Address</th>
	</tr>
	@foreach($mail as $order)
		<tr>
			<td>{{{$order->user->name}}} ({{{$order->user->email}}})</td>
			<td>{{{$order->saveon}}}</td>
			<td>{{{$order->coop}}}</td>
			<td>{{{$order->user->address()}}}</td>
		</tr>
	@endforeach
</table>
</div>
@stop