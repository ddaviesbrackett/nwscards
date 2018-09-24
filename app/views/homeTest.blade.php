@extends('layout')

@section('title')
	Home
@stop

@section('head-extra')
	<link rel="stylesheet" href="/styles/home.css"/>
	<script src="/script/home.js"></script>
@stop

@section('nav-extra')
	<li><a href="#about">About</a></li>
	<li><a href="#faq">FAQ</a></li>
	<li><a href="#contact">Contact</a></li>
@stop

@section('content')
<div class="masthead">
	<h1>Buy Grocery Cards<br/>Raise Money</h1>
        
	<h3>
            This year we've raised so far - {{{money_format('$%n',$totalThisYear)}}}<br/>
            From July 2014 we've raised - {{{money_format('$%n',$total)}}}<br/>
            Help us raise more &mdash; <em>without spending any extra!</em>
        </h3>
       
	<p>Generously supported by our store partners The Kootenay Co-Op and Save-On Foods</p>
	@if (Sentry::check())
		<a class="btn btn-outline-inverse btn-lg" href="/edit">Change Order</a>
	@else
		<a class="btn btn-outline-inverse btn-lg" href="/new">Order Now</a>
	@endif
	<a class="link order" href="/account">Checking on an existing order? Click here</a>
</div>

@stop