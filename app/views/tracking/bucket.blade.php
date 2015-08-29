@extends('layout')
@section('title')
	Profit Leaderboard
@stop

@section('head-extra')
@stop

@section('content')
<div class="masthead">
	<h1>{{{money_format( '$%n', $sum)}}} raised for {{{$name}}} so far</h1>
	<h3>{{{$name}}} currently has {{{$currentSupporters}}} supporters.</h3>
</div>
<div class="container-fluid">
<h4>Funds Raised</h4>
<table class='table'>
	<tr>
		<th>Order</th>
		<th>Amount Raised</th>
	</tr>
	@if (! empty($profitMap))
		@foreach($profitMap as $cutoffdateid => $profit)
			<tr>
				<td>{{{CutoffDate::find($cutoffdateid)->deliverydate()->format('F jS')}}}</td>
				<td>{{{money_format('$%n',$profit)}}}</td>
			</tr>
		@endforeach
	@endif
</table>
@if ( ! empty($pointsales) && count($pointsales) > 0)
	<h4>Amount Raised by Point Sales</h4>
	<table class='table'>
		<tr>
			<th>Sale</th>
			<th>Profit</th>
		</tr>
		@foreach($pointsales as $pointsale)
			<tr>
				<td>{{{$pointsale->saledate->format('F jS')}}}</td>
				<td>{{{money_format('$%n', $pointsale->pivot->profit)}}}</td>
			</tr>
		@endforeach
	</table>
@endif
@if (! empty($expenses) && count($expenses) > 0)
	<h4>Funds Paid Out</h4>
	<table class='table'>
		<tr>
			<th>Payout</th>
			<th>Amount</th>
		</tr>
			@foreach($expenses as $expense)
				<tr>
					<td>{{{$expense->expense_date->format('F jS')}}}</td>
					<td>{{{money_format('$%n',$expense->amount)}}}</td>
				</tr>
			@endforeach
	</table>
@endif
<p>Total available: {{{money_format( '$%n', $sum - $expenses->sum('amount'))}}}</p>
</div>
@stop