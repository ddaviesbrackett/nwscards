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
		<th>Delivery Date</th>
		<th># Orders</th>
		<th>Save-On Cards</th>
		<th>Co-op Cards</th>
	</tr>
	@foreach($model as $order)
		<tr>
			<td><a href="{{URL::route('admin-order', ['id' => $order['id']])}}">{{{$order['id']}}}</a></td>
			<td>{{{$order['delivery']}}}</td>
			<td>{{{$order['orders']}}}</td>
			<td>{{{$order['saveon']}}}</td>
			<td>{{{$order['coop']}}}</td>
		</tr>
	@endforeach
</table>
</div>
@stop