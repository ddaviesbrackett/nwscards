@extends('layout')

@section('title')
	My Account
@stop

@section('head-extra')
@stop

@section('content')
<div class="masthead">
	<h1>Thanks for your support!</h1>
	<p>
		Your order is already helping.
	</p>
</div>
<div class="container-fluid">
	<h3>Your standing order</h3>
	<div class="row">
		<div class="col-sm-3 text-right">Name:</div>
		<div class="col-sm-6"><b>{{{$user->name}}}</b></div>
	</div>
	<div class="row">
		<div class="col-sm-3 text-right">Cards:</div>
		<div class="col-sm-6"><b>{{{$user->coop}}}</b> Kooteny Co-op cards and <b>{{{$user->saveon}}}</b> Save On More cards, <b>{{{$user->schedule}}}</b></div>
	</div>
	<div class="row">
		<div class="col-sm-3 text-right">Next Order:</div>
		<div class="col-sm-6">Charged <b>{{{$payment[$user->schedule]}}}</b>, available <b>{{{$delivery[$user->schedule]}}}</b></div>
	</div>
	<div class="row">
		<div class="col-sm-3 text-right">Delivery Method:</div>
		<div class="col-sm-6">
			@if($user->deliverymethod)
				Cards will be <b>mailed</b> to:<br/>
				{{{$user->name}}}<br/>
				{{{$user->address1}}}<br/>
				{{{$user->address2}}}<br/>
				{{{$user->city}}},
				{{{$user->province}}}<br/>
				{{{$user->postal_code}}}
			@else
				Cards will be <b>picked up at the school</b> by <b>{{{$user->name}}}</b>
				@if(($user->pickupalt))
					or by <b>{{{$user->pickupalt}}}</b>
				@endif
				at the bottom of the steps at the Waldorf School either between 8AM and 8:30AM or between 2:30PM and 3:00PM
			@endif
		</div>
	</div>
	<p>Watch this space for the ability to change your order, coming soon!</p>
	<p>Watch this space for past deliveries, along with where the money went, coming soon!</p>
</div>
@stop