@extends('layout')

@section('title')
	Password Reminder
@stop

@section('head-extra')
@stop

@section('content')
<div class="masthead">
	<h1>Welcome Back!</h1>
	<p>
		You can choose a new password here.
	</p>
</div>
<div class="container-fluid">
	{{Form::open(['action'=>'RemindersController@postReset', 'method'=>'POST', 'class'=>'form login'])}}
		<input type="hidden" name="token" value="{{ $token }}">
		<div class="row" style='margin-top:20px;'>
		<div class="col-sm-4 col-sm-push-4">
			@if(Session::has('error'))
				<div class="alert alert-danger alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				  {{{Session::get('error')}}}
				</div>
			@endif
			<div class="callout">
			  <div class="form-group">
			    <label for="email">Email address</label>
			    <input type="email" class="form-control" id="email" name="email" placeholder="email">
			  </div>
			  <div class='form-group{{$errors->has("password")?" has-error":"";}}'>
				<label for='password'>Password:</label>
					<input type='password' class='form-control' placeholder='' id='password' name='password' value="{{Form::getValueAttribute('password', '')}}">
					@if($errors->has('password'))
						<span class='help-block'>{{{$errors->first('password')}}}</span>
					@endif
                                        <span class='help-block'>please choose a new, strong password between 6 to 15 characters. You'll be able to change your order with it.</span>

				</div>
				<div class='form-group{{$errors->has("password_confirmation")?" has-error":"";}}'>
					<label for='password_confirmation'>Password (again):</label>
					<input type='password' class='form-control' id='password_confirmation' name='password_confirmation' value="{{Form::getValueAttribute('password_confirmation', '')}}">
					@if($errors->has('password_confirmation'))
						<span class='help-block'>{{{$errors->first('password_confirmation')}}}</span>
					@endif
				</div>
			  <button type="submit" class="btn btn-danger">Reset Password</button>
			</div>
		</div>
		</div>
	{{Form::close()}}
</div>
@stop