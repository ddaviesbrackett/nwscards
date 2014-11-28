@extends('layout')

@section('title')
	Password Reminder
@stop

@section('head-extra')
@stop

@section('content')
<div class="masthead">
	<h1>Sorry you forgot!</h1>
	<p>
		Enter your email address and we'll send you an email with a link to reset your password.
	</p>
</div>
<div class="container-fluid">
	{{Form::open(['action'=>'RemindersController@postRemind', 'method'=>'POST', 'class'=>'form login'])}}
		<div class="row" style='margin-top:20px;'>
		<div class="col-sm-4 col-sm-push-4">
			@if(Session::has('error'))
				<div class="alert alert-danger alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				  {{{Session::get('error')}}}
				</div>
			@endif
			@if(Session::has('status'))
				<div class="alert alert-success alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				  {{{Session::get('status')}}}
				</div>
			@endif
			<div class="callout">
			  <div class="form-group">
			    <label for="email">Email address</label>
			    <input type="email" class="form-control" id="email" name="email" placeholder="email">
			  </div>
			  <button type="submit" class="btn btn-danger">Send Reminder</button>
			</div>
		</div>
		</div>
	{{Form::close()}}
</div>
@stop