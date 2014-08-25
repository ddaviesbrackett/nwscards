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
		<h1>Thanks for your support</h1>
	@endif
	<h3>Here's what's happening</h3>
</div>
<div class="container-fluid text-center">
	@if($message == 'order created')
		<h2>Confirmation</h2>
		<p>You'll receive an email shortly (to {{{$user->email}}}) with your order details.</p>
	@endif
	<div class="row">
			<h2>Your next order</h2>
			<p>You will be charged on <b>{{{$dates['charge'][$user->schedule]}}}</b>, by <b>{{{$user->payment?'credit card':'direct debit'}}}</b> (last 4 digits {{{$user->last_four}}}).</p>
			<p>Your cards will be available on <b>{{{$dates['delivery'][$user->schedule]}}}</b>.</p>
			@if($user->deliverymethod)
				<p>Your cards will be mailed to you that day.  They generally arrive on Thursday or Friday.</p>
			@else
				<p>You can pick your order up between 8AM and 8:30AM or 2:30PM and 3PM that day, at the bottom of the main stairs.</p>
			@endif
		<hr>
			<h2>Your recurring order</h2>
			<p>
				You have a <b style="text-transform:capitalize;">{{{$user->schedule}}}</b> order of<br/>
				<b>${{{$user->coop}}}00 from Kootenay Co-op</b><br/>
				<b>${{{$user->saveon}}}00 from Save-On</b>
			</p>
			Supporting:
			<ul style='list-style-type:none;padding-left:0;'>
				<li><b>the Tuition Reduction Fund</b></li>
				@foreach ($user->classesSupported() as $class => $supp)
					{{$supp?'<li><b>'.User::className($class).'</b></li>':''}}
					
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
		</div>
	</div>
	<hr>
	<div class="row text-center">
		<h2>Your order history</h2>
		(coming soon)
	</div>
</div>
@stop