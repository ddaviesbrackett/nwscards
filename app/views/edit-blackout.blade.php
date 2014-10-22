@extends('layout')

@section('title')
	Orders are being processed
@stop

@section('head-extra')
	<link rel="stylesheet" href="/styles/new.css"/>
@stop

@section('content')
<div class="masthead">
	<h1>
		Orders are being processed
	</h1>
</div>
<div class="container-fluid">
	<h4 class="callout-title">Sorry, you can't change your order right now</h4>
		<span>
			Orders are currently being processed and will be available for edit on <b>{{{@OrderController::GetBlackoutEndDate()->format('l, F jS')}}}</b>.
		</span>
</div>
@stop