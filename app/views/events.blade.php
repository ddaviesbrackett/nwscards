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
	<h1>Running Event:{{$name}}</h1>
        <h2>Cutoff date:{{$cutoffdate}}</h2>
</div>
@stop