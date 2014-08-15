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
	<p>Watch this space for the ability to change your order, coming soon!</p>
	<p>Watch this space for past deliveries, along with where the money went, coming soon!</p>
</div>
@stop