@extends('layout')

@section('title')
	Welcome
@stop

@section('head-extra')
	<link rel="stylesheet" href="/styles/new.css"/>

	<script src="/script/new.js"></script>
@stop

@section('content')
<div class="container-fluid">
	<h1>Thank You for supporting students and teachers at the Nelson Waldorf School</h1>
	<p>
		The All-School Grocery Card Fundraiser is an amazing opportunity to support students without spending any extra money!
	</p>
	{{Form::open(['url'=>'/new', 'method'=>'POST', 'class'=>'form-horizontal new-order'])}}
		<div class="well">
			<div class='form-group{{$errors->has("name")?" has-error":"";}}'>
				<label for='name' class='col-sm-2 text-right'>Name:</label>
				<div class='col-sm-8'>
					<input type='text' class='form-control' placeholder='your name' id='name' name='name' value="{{Form::getValueAttribute('name', '')}}">
					@if($errors->has('name'))
						<span class='help-block'>{{{$errors->first('name')}}}</span>
					@endif
				</div>
			</div>
			<div class='form-group{{{$errors->has("email")?" has-error":""}}}'>
				<label for='email' class='col-sm-2 text-right'>Email:</label>
				<div class='col-sm-8'>
					<input type='email' class='form-control' placeholder='someone@somewhere.com' id='email' name='email' value="{{Form::getValueAttribute('email', '')}}">	
				@if($errors->has('email'))
					<span class='help-block'>{{{$errors->first('email')}}}</span>
				@endif
				</div>
			</div>
			<div class='form-group{{$errors->has("password")?" has-error":"";}}'>
				<label for='password' class='col-sm-2 text-right'>Password:</label>
				<div class='col-sm-8'>
					<input type='password' class='form-control' placeholder='(so you can manage your order)' id='password' name='password' value="">
					@if($errors->has('password'))
						<span class='help-block'>{{{$errors->first('password')}}}</span>
					@endif
				</div>
			</div>
			<div class='form-group{{$errors->has("phone")?" has-error":"";}}'>
				<label for='phone' class='col-sm-2 text-right'>Phone Number:</label>
				<div class='col-sm-8'>
					<input type='tel' class='form-control' placeholder='(250) 555-5555' id='phone' name='phone' value="{{Form::getValueAttribute('phone', '')}}">
					@if($errors->has('phone'))
						<span class='help-block'>{{{$errors->first('phone')}}}</span>
					@endif
				</div>
			</div>
			<div class='form-group{{$errors->has("address1")?" has-error":"";}}'>
				<label for='address1' class='col-sm-2 text-right'>Address:</label>
				<div class='col-sm-8'>
					<input type='text' class='form-control' placeholder='your mailing address' id='address1' name='address1' value="{{Form::getValueAttribute('address1', '')}}">
					@if($errors->has('address1'))
						<span class='help-block'>{{{$errors->first('address1')}}}</span>
					@endif
				</div>
			</div>
			<div class='form-group{{$errors->has("address2")?" has-error":"";}}'>
				<label for='address2' class='col-sm-2 text-right'>Address 2:</label>
				<div class='col-sm-8'>
					<input type='text' class='form-control' id='address2' name='address2' value="{{Form::getValueAttribute('address2', '')}}">
					@if($errors->has('address2'))
						<span class='help-block'>{{{$errors->first('address2')}}}</span>
					@endif
				</div>
			</div>
			<div class='form-group{{$errors->has("city") || $errors->has("postal_code")?" has-error":"";}}'>
				<label for='city' class='col-sm-2 text-right'>City:</label>
				<div class='col-sm-3'>
					<input type='text' class='form-control' placeholder='Nelson? Ymir? Salmo? Slocan?' id='city' name='city' value="{{Form::getValueAttribute('city', '')}}">
					@if($errors->has('city'))
						<span class='help-block'>{{{$errors->first('city')}}}</span>
					@endif
				</div>
				<label for='postal_code' class='col-sm-2 text-right'>Postal Code:</label>
				<div class='col-sm-3'>
					<input type='text' class='form-control' placeholder='V1A 1A1' id='postal_code' name='postal_code' value="{{Form::getValueAttribute('postal_code', '')}}">
					@if($errors->has('postal_code'))
						<span class='help-block'>{{{$errors->first('postal_code')}}}</span>
					@endif
				</div>
			</div>
		</div>
		<div class="well">
			<div class="form-group">
				<label class="col-sm-2 text-right">Classes to support:</label>
				<div class="col-sm-8">
					<div class="radio"><label><input type="radio" name="indiv-class" id="indiv-class-school" checked/>I want to support the whole school</label></div>
					<div class="radio"><label><input type="radio" name="indiv-class" id="indiv-class-classes"/>I want to support the whole school <strong>and</strong> one or more classes</label></div>
				</div>
			</div>
			<div class="form-group individual-classes">
				<div class="col-sm-offset-2 col-sm-4 col-md-2"><div class="checkbox"><label><input type='checkbox' name='marigold'>Marigold Daycare</label></div></div>
				<div class="col-sm-offset-2 col-sm-offset-0 col-sm-4 col-md-2"><div class="checkbox"><label><input type='checkbox' name='daisy'>Daisy Daycare</label></div></div>
				<div class="col-sm-offset-2 col-md-offset-0 col-sm-4 col-md-2"><div class="checkbox"><label><input type='checkbox' name='sunflower'>Sunflower Kindergarten</label></div></div>
				<div class="col-sm-offset-2 col-sm-offset-0 col-sm-4 col-md-2"><div class="checkbox"><label><input type='checkbox' name='bluebell'>Bluebell Kindergarten</label></div></div>
			</div>
			<div class="form-group individual-classes">
				<div class="col-sm-offset-2 col-sm-4 col-md-2"><div class="checkbox"><label><input type='checkbox' name='class_1'>Class 1 (Mr. Lunde)</label></div></div>
				<div class="col-sm-offset-2 col-sm-offset-0 col-sm-4 col-md-2"><div class="checkbox"><label><input type='checkbox' name='class_2'>Class 2 (Ms. Longson)</label></div></div>
				<div class="col-sm-offset-2 col-md-offset-0 col-sm-4 col-md-2"><div class="checkbox"><label><input type='checkbox' name='class_3'>Class 3 (Mr. Fukada)</label></div></div>
				<div class="col-sm-offset-2 col-sm-offset-0 col-sm-4 col-md-2"><div class="checkbox"><label><input type='checkbox' name='class_4'>Class 4 (Ms. Guthrie)</label></div></div>
			</div>
			<div class="form-group individual-classes">
				<div class="col-sm-offset-2 col-sm-4 col-md-2"><div class="checkbox"><label><input type='checkbox' name='class_5'>Class 5 (Ms. Mulligan)</label></div></div>
				<div class="col-sm-offset-2 col-sm-offset-0 col-sm-4 col-md-2"><div class="checkbox"><label><input type='checkbox' name='class_6'>Class 6 (Mr. Goncalves)</label></div></div>
				<div class="col-sm-offset-2 col-md-offset-0 col-sm-4 col-md-2"><div class="checkbox"><label><input type='checkbox' name='class_7'>Class 7 (Ms. Thayer)</label></div></div>
				<div class="col-sm-offset-2 col-sm-offset-0 col-sm-4 col-md-2"><div class="checkbox"><label><input type='checkbox' name='class_8'>Class 8 (Ms. Oese-Lloyd)</label></div></div>
			</div>
		</div>
		<div class="well">
			<div class="form-group">
				<label class="col-sm-2 text-right">Schedule:</label>
				<div class="col-sm-8">
					<div class="col-xs-6 radio"><label><input type="radio" name="schedule" id="schedule_biweekly" value="biweekly"/>Every 2 Weeks</label></div>
					<div class="col-xs-6 radio"><label><input type="radio" name="schedule" id="schedule_4weekly" value="4weekly"/>Every 4 Weeks</label></div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 text-right">Cards to Order:</label>
				<div class="col-sm-8">
					<label class="col-xs-2" for="saveon">Save-On:</label>
					<div class="col-xs-4">
						<div class="input-group">
							<input type="number" min="0" step="1" class="form-control" placeholder="# of Save On More cards" id="saveon" name="saveon" value="{{Form::getValueAttribute('saveon', '0')}}"/>
							<span class="input-group-addon">x $100</span>
						</div>
					</div>

					<label class="col-xs-2" for="coop">Co-op:</label>
					<div class="col-xs-4">
						<div class="input-group">
							<input type="number" min="0" step="1" class="form-control" placeholder="# of Kootenay Co-op cards" id="coop" name="coop" value="{{Form::getValueAttribute('coop', '0')}}"/>
							<span class="input-group-addon">x $100</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="well">
			<div class="form-group">
				<label class="col-sm-2 text-right">Payment:</label>
				<div class="col-sm-8">
					<div class="col-xs-6 radio"><label><input type="radio" name="payment" id="payment_debit" value="debit" checked/>Direct Debit (we make more money with debit!)</label></div>
					<div class="col-xs-6 radio"><label><input type="radio" name="payment" id="payment_credit" value="credit"/>Credit Card</label></div>
				</div>
			</div>
			<div class="row payment debit">
				debit row is here
			</div>
			<div class="row payment credit">
				credit row is here
			</div>
		</div>
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">
				<button type='submit' class='btn btn-primary'>Sign Me Up!</button>
			</div>
		</div>

	{{Form::close()}}
</div>
@stop