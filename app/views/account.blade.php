@extends('layout')

@section('title')
	My Account
@stop

@section('head-extra')
@stop

@section('content')
<div class="masthead">
	<h1>Thanks for your support</h1>
	<h3>Here's what's happening</h3>
</div>
<div class="container-fluid text-center">
	<h2>Your next order</h2>
	<p>You will be charged on <b>{{{$dates['charge'][$user->schedule]}}}</b>, by <b>{{{$user->payment?'credit card':'direct debit'}}}</b>.
	<p>Your cards will be available on <b>{{{$dates['delivery'][$user->schedule]}}}</b>.
	@if($user->deliverymethod)
		<p>Your cards will be mailed to you that day.  They generally arrive on Thursday or Friday.</p>
	@else
		<p>You can pick your order up between 8AM and 8:30AM or 2:30PM and 3PM that day, at the bottom of the main stairs.</p>
	@endif

	<hr>

	<h2>Your recurring order</h2>
	<p>
		You have ordered<br/>
		<b>${{{$user->coop}}}00 from Kootenay Co-op</b><br/>
		<b>${{{$user->saveon}}}00 from Save-On</b><br/>
	</p>
	<p>
		<b style="text-transform:capitalize;">{{{$user->schedule}}}</b><br/>
	</p>

	<p>
		Your cards are being
		@if($user->deliverymethod)
			<b>mailed to you</b> at<br/>
			{{{$user->name}}}<br/>
				{{{$user->address1}}}<br/>
				{{{$user->address2?$user->address2 + '<br/>':''}}}
				{{{$user->city}}},
				{{{$user->province}}}<br/>
				{{{$user->postal_code}}}
		@else
			<b>picked up at the school</b> by you
			@if(($user->pickupalt))
					or by <b>{{{$user->pickupalt}}}</b>
			@endif
		@endif
	</p>
	<hr>
	<h2>Your order history</h2>
	(coming soon)
</div>
@stop