@extends('layout')
@section('title')
	Profit Leaderboard
@stop

@section('head-extra')
@stop

@section('content')
<div class="masthead">
	<h1>${{{$sum}}} raised for {{{$name}}} so far</h1>
</div>
<div class="container-fluid">
<table class='table'>
	<tr>
		<th>Order</th>
		<th>Amount Raised</th>
	</tr>
	@if (! empty($orders))
		@foreach($orders as $order)
			<tr>
				<td>{{{$order->cutoffdate->deliverydate()->format('F jS')}}}</td>
				<td>{{{money_format('$%n',$order->profit)}}}</td>
			</tr>
		@endforeach
	@endif
</table>
</div>
@stop