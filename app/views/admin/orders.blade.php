@extends('layout')
@section('title')
	Order list
@stop

@section('head-extra')
@stop

@section('content')
<div class="masthead">
	<h1>Order list</h1>
</div>
<div class="container-fluid">
<table class='table'>
	<tr>
		<th></th>
		<th>Cutoff Date</th>
		<th>Charge Date</th>
		<th>Delivery Date</th>
	</tr>
	@foreach($model as $order)
		<tr>
			<td><a href="{{URL::route('admin-order', ['id' => $order['id']])}}">{{{$order['id']}}}</a></td>
			<td>{{{$order['cutoff']}}}</td>
			<td>{{{$order['charge']}}}</td>
			<td>{{{$order['delivery']}}}</td>
		</tr>
	@endforeach
</table>
</div>
@stop