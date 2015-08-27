@extends('layout')

@section('title')
	Error resuming your order
@stop

@section('head-extra')
	<link rel="stylesheet" href="/styles/new.css"/>
@stop

@section('content')
<div class="masthead">
	<h1>
		Error resuming your order
	</h1>
</div>
<div class="container-fluid">
	<h4 class="callout-title">Sorry, Your order couldn't be resumed</h4>
		<p>
			We couldn't resume your order.  Usually, that means it's either already resumed or the link you clicked got changed between your email and your browser.
		</p>
		<p>
			You can always <a href="/account">log in to your account</a> and see what's up, though!
		</p>
</div>
@stop