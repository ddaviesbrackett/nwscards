@extends('layout')

@section('title')
	Log In
@stop

@section('head-extra')
@stop

@section('content')
<div class="masthead">
	<h1>Thanks for your support!</h1>
	<p>
		Log in to see your order and to make changes.
	</p>
</div>
<div class="container-fluid">
	{{Form::open(['url'=>'/login', 'method'=>'POST', 'class'=>'form login'])}}
		<div class="row">
		<div class="col-sm-4 col-sm-push-4">
			<div class="callout" style='margin-top:20px;'>
			  <div class="form-group">
			    <label for="email">Email address</label>
			    <input type="email" class="form-control" id="email" name="email" placeholder="email">
			  </div>
			  <div class="form-group">
			    <label for="password">Password</label>
			    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
			  </div>
			  <button type="submit" class="btn btn-primary">Log in</button>
			</div>
		</div>
		</div>
	{{Form::close()}}
</div>
@stop