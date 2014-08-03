@extends('layout')

@section('title')
	Home
@stop

@section('head-extra')
	<link rel="stylesheet" href="/styles/home.css"/>
@stop

@section('content')
<div class="masthead">
	<h1>Buy Cards,  Help Kids</h1>
	<h3>We've raised {{{$total}}} so far. Help us raise more.</h3>
	<a class="btn btn-outline-inverse btn-lg" href="/new">Order Cards Now</a>
	<div class="container-fluid">
		<div class="col-sm-4 col-sm-offset-2">
			<h4>How your order helps</h4>
			We raise funds for the Nelson Waldorf School's Tuition Reduction Fund and, if you choose, one or more
			individual classes at the school.
		</div>
		<div class="col-sm-4">
			<h4>Help us raise money without donating</h4>
			For each $100 card you buy through us, the grocery store donates a percentage.
		</div>
	</div>
</div>
<div class-"container-fluid">

</div>
@stop