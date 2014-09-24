@extends('layout')

@section('title')
	My Account
@stop

@section('head-extra')
@stop

@section('content')
<div class="masthead">
	@if($message == 'order created')
		<h1>Your order succeeded</h1>
	@else
		<h1>{{{money_format('%n', $user->orders->sum('profit'))}}} raised so far</h1>
	@endif
	<h3>Here's what's happening</h3>
</div>
<div class="container-fluid text-center">
	@if($message == 'order created')
		<h2>Confirmation</h2>
		<p>You'll receive an email shortly (to {{{$user->email}}}) with your order details.</p>
	@endif
	<div class="row">
		@if(! is_null($mostRecentOrder) && $mostRecentOrder->created_at > (new \Carbon\Carbon())->addDays(-8))
			<h2>Your current order</h2>
			<p>The charge date for your current order is <b>{{{$mostRecentOrder->cutoffdate->chargedate()->diffForHumans()}}}</b>.  </p>
			<p>Your cards will be available <b>{{{$mostRecentOrder->cutoffdate->deliverydate()->diffForHumans()}}}</b>.</p>
			@if($mostRecentOrder->deliverymethod)
				<p>Your cards will be mailed to you that day.  They generally arrive on Thursday or Friday.</p>
			@else
				<p>You can pick your order up between 8AM and 8:30AM or 2:30PM and 3PM that day, at the bottom of the main stairs.</p>
			@endif
		<hr/>
		@endif
			<h2>Your next order</h2>
			<p>You will be charged on <b>{{{$dates[$user->schedule]['charge']}}}</b>, by <b>{{{$user->payment?'credit card':'direct debit'}}}</b> (last 4 digits {{{$user->last_four}}}).</p>
			<p>Your cards will be available on <b>{{{$dates[$user->schedule]['delivery']}}}</b>.</p>
		<hr/>
			<h2>Your recurring order</h2>
			@if($user->coop > 0 || $user->saveon > 0)
				<p>
					You have a <b style="text-transform:capitalize;">{{{$user->schedule}}}</b> order of<br/>
					@if($user->coop > 0)
						<b>${{{$user->coop}}}00 from Kootenay Co-op</b><br/>
					@endif
					@if($user->saveon > 0)
						<b>${{{$user->saveon}}}00 from Save-On</b>
					@endif
				</p>
				Supporting:
				<ul style='list-style-type:none;padding-left:0;'>
					<li><b>the Tuition Reduction Fund</b></li>
					@foreach ($user->classesSupported() as $class)
						<li><b>{{{User::className($class)}}}</b></li>
					@endforeach
				</ul>
				<p>
					Your cards are being
					@if($user->deliverymethod)
						<b>mailed to you</b> at<br/>
						<span class="text-left">
						{{{$user->name}}}<br/>
							{{{$user->address1}}}<br/>
							{{{$user->address2?$user->address2 + '<br/>':''}}}
							{{{$user->city}}},
							{{{$user->province}}}<br/>
							{{{$user->postal_code}}}
						</span>
					@else
						<b>picked up at the school</b> by you
						@if(($user->pickupalt))
								or by <b>{{{$user->pickupalt}}}</b>
						@endif
					@endif
				</p>
			@else
				You have no recurring order. You'll make more money for the school if you order more cards!
			@endif
			<h2>Your order history</h2>
			<table class="table text-left">
				<tr>
					<th>Date</th>
					<th>Cards</th>
					<th>Class(es)</th>
					<th>Other</th>
				</tr>
				@foreach($user->orders as $order)
					<tr>
						<td>
							{{{$order->cutoffdate->deliverydate()->format('F jS Y')}}}
						</td>
						<td>
							@if($order->saveon > 0)
								{{{$order->saveon}}} Save-On
							@endif
							@if($order->coop > 0)
								{{{$order->coop}}} Co-Op
							@endif
						</td>
						<td>
							@foreach($order->classesSupported() as $class)
								{{{User::className($class)}}}: ${{{$order[$class]}}}<br/>
							@endforeach
						</td>
						<td>
							Tuition Reduction: ${{{$order->tuitionreduction}}}<br/>
							PAC: ${{{$order->pac}}}
						</td>
					</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>
@stop