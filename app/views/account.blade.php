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
		<div class="col-sm-3 text-right">Kootenay Co-op cards:</div>
		<div class="col-sm-6"><b>{{{$user->coop}}}</b></div>
	</div>
	<div class="row">
		<div class="col-sm-3 text-right">Save On More cards:</div>
		<div class="col-sm-6"><b>{{{$user->saveon}}}</b></div>
	</div>
	<div class="row">
		<div class="col-sm-3 text-right">Order Frequency:</div>
		<div class="col-sm-6"><b>{{{$user->schedule}}}</b></div>
	</div>
	
</div>
@stop