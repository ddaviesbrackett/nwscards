@extends('layout')

@section('title')
	New Order
@stop

@section('head-extra')
	<link rel="stylesheet" href="/styles/new.css"/>

	<script src="/script/new.js"></script>
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
@stop

@section('content')
<div class="masthead">
	<h1>Your support means a lot</h1>
	<p>
		Raise  money for students and teachers at Nelson Waldorf without spending any extra money
	</p>
</div>
<div class="container-fluid">
	{{Form::open(['url'=>'/new', 'method'=>'POST', 'class'=>'form-horizontal new-order'])}}
		<h4 class="callout-title">Make a Recurring Order</h4>
		<div class="callout order">
			<div class='form-group{{$errors->has("coop")?" has-error":"";}}'>
				<label for='coop' class='col-sm-3 text-right'>Kootenay Co-op:</label>
				<div class='col-sm-3'>
					<div class="input-group">
						<input type="number" min="0" step="1" class="form-control" placeholder="" id="coop" name="coop" value="{{Form::getValueAttribute('coop', '0')}}"/>
						<span class="input-group-addon">x $100</span>
					</div>
				</div>
				<div class='col-sm-6'>
					<div class="alert alert-warning alert-dismissible hidden" role="alert">
					  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					  That's $<span class="amt"></span>00 in cards!
					</div>
				</div>
				<div class='col-sm-12 text-warning'>
					@if($errors->has('coop'))
						<span class='help-block'>{{{$errors->first('coop')}}}</span>
					@endif
				</div>
			</div>
			<div class='form-group{{$errors->has("saveon")?" has-error":"";}}'>
				<label for='saveon' class='col-sm-3 text-right'>Save-On:</label>
				<div class='col-sm-3'>
					<div class="input-group">
						<input type="number" min="0" step="1" class="form-control" placeholder="" id="saveon" name="saveon" value="{{Form::getValueAttribute('saveon', '0')}}"/>
						<span class="input-group-addon">x $100</span>
					</div>
				</div>
				<div class='col-sm-6'>
					<div class="alert alert-warning alert-dismissible hidden" role="alert">
					  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					  That's $<span class="amt"></span> in cards!
					</div>
				</div>
				<div class='col-sm-12'>
					@if($errors->has('saveon'))
						<span class='help-block'>{{{$errors->first('saveon')}}}</span>
					@endif
				</div>
			</div>
			<div class='form-group{{$errors->has("schedule")?" has-error":"";}}'>
				<label class="col-sm-3 text-right">Schedule:</label>
				<div class="col-sm-8">
					<div class="radio"><label><input type="radio" name="schedule" id="schedule_biweekly" value="biweekly" {{Form::getValueAttribute('schedule', '') == 'biweekly'?'checked':''}} />Every 2 weeks, starting <b>{{{$dates['delivery']['biweekly']}}}</b></label></div>
					<div class="radio"><label><input type="radio" name="schedule" id="schedule_monthly" value="monthly" {{Form::getValueAttribute('schedule', '') == 'monthly'?'checked':''}} />Once a month, starting <b>{{{$dates['delivery']['monthly']}}}</b></label></div>
					@if($errors->has('schedule'))
						<span class='help-block'>{{{$errors->first('schedule')}}}</span>
					@endif
				</div>
			</div>
		</div>
		<h4 class="callout-title">Enter Your Information</h4>
		<div class="callout">
			<div class='form-group{{$errors->has("name")?" has-error":"";}}'>
				<label for='name' class='col-sm-3 text-right'>Name:</label>
				<div class='col-sm-8'>
					<input type='text' class='form-control' placeholder='your name' id='name' name='name' value="{{Form::getValueAttribute('name', '')}}">
					@if($errors->has('name'))
						<span class='help-block'>{{{$errors->first('name')}}}</span>
					@endif
				</div>
			</div>
			<div class='form-group{{{$errors->has("email")?" has-error":""}}}'>
				<label for='email' class='col-sm-3 text-right'>Email:</label>
				<div class='col-sm-8'>
					<input type='email' class='form-control' placeholder='someone@somewhere.com' id='email' name='email' value="{{Form::getValueAttribute('email', '')}}">
				@if($errors->has('email'))
					<span class='help-block'>{{{$errors->first('email')}}}</span>
				@endif
				</div>
			</div>
			<div class='form-group{{$errors->has("phone")?" has-error":"";}}'>
				<label for='phone' class='col-sm-3 text-right'>Phone Number:</label>
				<div class='col-sm-8'>
					<input type='tel' class='form-control' placeholder='(250) 555-5555' id='phone' name='phone' value="{{Form::getValueAttribute('phone', '')}}">
					@if($errors->has('phone'))
						<span class='help-block'>{{{$errors->first('phone')}}}</span>
					@endif
				</div>
			</div>
			<div class='form-group{{$errors->has("address1")?" has-error":"";}}'>
				<label for='address1' class='col-sm-3 text-right'>Address:</label>
				<div class='col-sm-8'>
					<input type='text' class='form-control' placeholder='your mailing address' id='address1' name='address1' value="{{Form::getValueAttribute('address1', '')}}">
					@if($errors->has('address1'))
						<span class='help-block'>{{{$errors->first('address1')}}}</span>
					@endif
				</div>
			</div>
			<div class='form-group{{$errors->has("address2")?" has-error":"";}}'>
				<label for='address2' class='col-sm-3 text-right'>Address 2:</label>
				<div class='col-sm-8'>
					<input type='text' class='form-control' id='address2' name='address2' value="{{Form::getValueAttribute('address2', '')}}">
					@if($errors->has('address2'))
						<span class='help-block'>{{{$errors->first('address2')}}}</span>
					@endif
				</div>
			</div>
			<div class='form-group{{$errors->has("city") || $errors->has("postal_code")?" has-error":"";}}'>
				<label for='city' class='col-sm-3 text-right'>City:</label>
				<div class='col-sm-3'>
					<input type='text' class='form-control' placeholder='Nelson? Ymir? Salmo? Slocan?' id='city' name='city' value="{{Form::getValueAttribute('city', '')}}">
					@if($errors->has('city'))
						<span class='help-block'>{{{$errors->first('city')}}}</span>
					@endif
				</div>
				<label for='postal_code' class='col-sm-3 text-right'>Postal Code:</label>
				<div class='col-sm-2'>
					<input type='text' class='form-control' placeholder='V1A 1A1' id='postal_code' name='postal_code' value="{{Form::getValueAttribute('postal_code', '')}}">
					@if($errors->has('postal_code'))
						<span class='help-block'>{{{$errors->first('postal_code')}}}</span>
					@endif
				</div>
			</div>
			<div class='form-group{{$errors->has("password")?" has-error":"";}}'>
				<label for='password' class='col-sm-3 text-right'>Password:</label>
				<div class='col-sm-8'>
					<input type='password' class='form-control' placeholder='' id='password' name='password' value="{{Form::getValueAttribute('password', '')}}">
					@if($errors->has('password'))
						<span class='help-block'>{{{$errors->first('password')}}}</span>
					@endif
					<span class='help-block'>please choose a new, strong password. You'll be able to change your order with it.</span>
				</div>
			</div>
			<div class='form-group{{$errors->has("password-repeat")?" has-error":"";}}'>
				<label for='password' class='col-sm-3 text-right'>Password (again):</label>
				<div class='col-sm-8'>
					<input type='password' class='form-control' id='password-repeat' name='password-repeat' value="{{Form::getValueAttribute('password-repeat', '')}}">
					@if($errors->has('password'))
						<span class='help-block'>{{{$errors->first('password-repeat')}}}</span>
					@endif
				</div>
			</div>
		</div>
		<h4 class="callout-title">Decide who to Support</h4>
		<div class="callout">
			<div class="form-group">
				<div class="col-sm-12">
					<div class="radio"><label><input type="radio" name="indiv-class" id="indiv-class-school" value="school" {{Form::getValueAttribute('indiv-class', 'school') == 'school'?'checked':''}}/>I want to support the whole school</label></div>
					<div class="radio"><label><input type="radio" name="indiv-class" id="indiv-class-classes" value="class" {{Form::getValueAttribute('indiv-class', '') == 'class'?'checked':''}}/>I want to support the whole school <strong>and</strong> one or more classes</label></div>
				</div>
			</div>
			<!-- TODO check form::getvalueattribute for the checkboxes here -->
			<div class="form-group individual-classes">
				<div class="col-sm-offset-2 col-sm-4"><div class="checkbox"><label><input type='checkbox' name='marigold'>Marigold Daycare</label></div></div>
				<div class="col-sm-offset-2 col-sm-4"><div class="checkbox"><label><input type='checkbox' name='daisy'>Daisy Daycare</label></div></div>
				<div class="col-sm-offset-2 col-sm-4"><div class="checkbox"><label><input type='checkbox' name='sunflower'>Sunflower Kindergarten</label></div></div>
				<div class="col-sm-offset-2 col-sm-4"><div class="checkbox"><label><input type='checkbox' name='bluebell'>Bluebell Kindergarten</label></div></div>
			</div>
			<div class="form-group individual-classes">
				<div class="col-sm-offset-2 col-sm-4"><div class="checkbox"><label><input type='checkbox' name='class_1'>Class 1 (Mr. Lunde)</label></div></div>
				<div class="col-sm-offset-2 col-sm-4"><div class="checkbox"><label><input type='checkbox' name='class_2'>Class 2 (Ms. Longson)</label></div></div>
				<div class="col-sm-offset-2 col-sm-4"><div class="checkbox"><label><input type='checkbox' name='class_3'>Class 3 (Mr. Fukada)</label></div></div>
				<div class="col-sm-offset-2 col-sm-4"><div class="checkbox"><label><input type='checkbox' name='class_4'>Class 4 (Ms. Guthrie)</label></div></div>
			</div>
			<div class="form-group individual-classes">
				<div class="col-sm-offset-2 col-sm-4"><div class="checkbox"><label><input type='checkbox' name='class_5'>Class 5 (Ms. Mulligan)</label></div></div>
				<div class="col-sm-offset-2 col-sm-4"><div class="checkbox"><label><input type='checkbox' name='class_6'>Class 6 (Mr. Goncalves)</label></div></div>
				<div class="col-sm-offset-2 col-sm-4"><div class="checkbox"><label><input type='checkbox' name='class_7'>Class 7 (Ms. Thayer)</label></div></div>
				<div class="col-sm-offset-2 col-sm-4"><div class="checkbox"><label><input type='checkbox' name='class_8'>Class 8 (Ms. Oese-Lloyd)</label></div></div>
			</div>
			<div class="form-group individual-classes" style="margin-top:10px;">
				<label for="referrer" class="col-sm-3 text-right">Referring Family:</label>
				<div class="col-sm-8">
					<input type='text' class='form-control' placeholder='optional - who told you about this program?' id='referrer' name='referrer' value="{{Form::getValueAttribute('referrer', '')}}">
				</div>
			</div>
		</div>
		<h4 class="callout-title">Choose Payment</h4>
		<div class="callout">
			<span class="help-block info">You will be charged for your first delivery on 
				<b>
					<span class="schedule monthly">{{{$dates['charge']['monthly']}}}</span>
					<span class="schedule biweekly">{{{$dates['charge']['biweekly']}}}</span>
				</b> 
			(2 business days before delivery).</span>
			<div class="form-group">
				<div class="col-sm-12">
					<div class="radio"><label><input type="radio" name="payment" id="payment_debit" value="debit" {{Form::getValueAttribute('payment', '') == 'debit'?'checked':''}}/>Direct Debit (we make more money with debit)</label></div>
					<div class="payment debit">
						<div class="form-group">
							<div class="col-sm-offset-2">
								<img src="images/void_cheque.gif" alt="Void Cheque showing location of branch, institution, and account numbers" class="img-thumbnail img-responsive"/>
							</div>
						</div>
						<div class='debitnumbers form-group{{$errors->has("debit-transit") || $errors->has("debit-institution") || $errors->has("debit-account")?" has-error":"";}}'>
							<label class="col-sm-2 text-right" for="debit-transit">Branch Number:</label>
							<div class="col-sm-2">
								<input type='text' class='form-control' placeholder='' id='debit-transit' name='debit-transit' value="{{Form::getValueAttribute('debit-transit', '')}}">
							</div>
							<label class="col-sm-2 text-right" for="debit-institution">Institution Number:</label>
							<div class="col-sm-2">
								<input type='text' class='form-control' placeholder='' id='debit-institution' name='debit-institution' value="{{Form::getValueAttribute('debit-institution', '')}}">
							</div>
							<label style="padding-left:5px;" class="col-sm-1 text-right" for="debit-account">Account Number:</label>
							<div class="col-sm-3">
								<input type='text' class='form-control' placeholder='' id='debit-account' name='debit-account' value="{{Form::getValueAttribute('debit-account', '')}}">
							</div>
							<div style="clear:both;"></div>
							<div class="col-sm-4">
								@if($errors->has('debit-transit'))
									<div class='help-block text-right'>{{{$errors->first('debit-transit')}}}</div>
								@endif
							</div>
							<div class="col-sm-4">
								@if($errors->has('debit-institution'))
									<div class='help-block text-right'>{{{$errors->first('debit-institution')}}}</div>
								@endif
							</div>
							<div class="col-sm-4">
								@if($errors->has('debit-account'))
									<div class='help-block text-right'>{{{$errors->first('debit-account')}}}</div>
								@endif
							</div>
						</div>
						<div class="form-group{{$errors->has('debitterms')?' has-error ':''}}">
							<div class="col-sm-offset-1 col-sm-11">
								<div class="checkbox"><label><input type='checkbox' name='debitterms'>I have read and agree to the <a data-toggle="modal" data-target="#debitterms">terms of the Payor's Personal Pre-Authorized Debit (PAD) Agreement</a></label></div>
								@if($errors->has('debit-account'))
									<div class='help-block'>{{{$errors->first('debitterms')}}}</div>
								@endif
							</div>
						</div>
					</div>
					<div class="radio"><label><input type="radio" name="payment" id="payment_credit" value="credit" {{Form::getValueAttribute('payment', '') == 'credit'?'checked':''}}/>Credit Card</label></div>
					<div class="payment credit row">
						<div class="col-sm-6 col-sm-offset-3">
							<div class="form-group has-error payment-errors-group">
								<div class='help-block payment-errors'></div>
							</div>
							<div class="form-group">
			                    <label>Cardholder's Name</label>
			                    <input type="text" class="form-control" value="">
			                </div>
			                <div class="form-group">
			                    <label>Card Number</label>
			                    <input type="text" class="form-control" data-stripe="number" value="">
			                </div>
			                <div class="form-group cc-smallnumbers">
			                    <div class="col-sm-4">
			                            <label>Exp Month</label>
			                            <input type="text" class="form-control" placeholder="MM" data-stripe="exp-month" value="">
			                    </div>
			                    <div class="col-sm-4">
			                            <label>Exp Year</label>
			                            <input type="text" class="form-control" placeholder="YYYY" data-stripe="exp-year" value="">
			                    </div>
			                    <div class="col-sm-4">
			                            <label>CVC</label>
			                            <input type="text" class="form-control" placeholder="Ex. 331" data-stripe="cvc" value="">
			                    </div>
			                </div>
		                </div>
					</div>
				</div>
			</div>
		</div>
		<h4 class="callout-title">Choose Delivery</h4>
		<div class="callout">
			<div class='form-group{{$errors->has("deliverymethod")?" has-error":"";}}'>
				<div class="col-sm-12">
					<div class="radio"><label><input type="radio" name="deliverymethod" id="deliverymethod_pickup" value="pickup" {{Form::getValueAttribute('schedule', '') == 'pickup'?'checked':''}} />Pickup at the Nelson Waldorf School</label></div>
					<div class="deliverymethod pickup form-group">
						<div class="col-sm-12">
							<input type='text' class='form-control' placeholder='Is someone else picking up your order?' id='pickupalt' name='pickupalt' value="{{Form::getValueAttribute('pickupalt', '')}}">
							<span class="help-block">You'll have to sign for your cards.  If someone else can sign for them, enter their name here.</span>
						</div>
					</div>
					<div class="radio"><label><input type="radio" name="deliverymethod" id="deliverymethod_mail" value="mail" {{Form::getValueAttribute('schedule', '') == 'pickup'?'checked':''}} />Mail to address above</label></div>
					<div class="deliverymethod mail form-group{{$errors->has('mailwaiver')?' has-error':'';}}">
						<div class="col-sm-12">
							<div class="checkbox"><label><input type='checkbox' name='mailwaiver'>I hereby release NWS PAC of any liability regarding sending my ordered grocery cards by regular mail.</label></div>
							@if($errors->has('mailwaiver'))
								<span class='help-block'>You must agree to this waiver to complete your order.</span>
							@endif
						</div>
					</div>
					@if($errors->has('deliverymethod'))
						<span class='help-block'>{{{$errors->first('deliverymethod')}}}</span>
					@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 text-center" style="padding-top:3em; padding-bottom:3em;">
				<button type='submit' class='btn btn-danger btn-lg'>Sign Me Up!</button>
			</div>
		</div>
	{{Form::close()}}
</div>
<script>
	Stripe.setPublishableKey('pk_test_JNPaJxAuLSeYN8biyB09Cb5O');
</script>

<div class="modal fade" id="debitterms" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Terms and Conditions</h4>
      </div>
      <div class="modal-body">
      	<p>
       	I authorize the Nelson Waldorf School Parent Association (hereinafter “PAC”) to make pre-authorized debits (PAD) from my account with the aforementioned 
       	financial institution, either:
       	<ul>
	       	<li>bi-weekly, commencing on {{{$dates['charge']['biweekly']}}} and ending on June 3, 2015</li>
	       	<li>monthly, commencing on {{{$dates['charge']['monthly']}}} and ending on June 3, 2015</li>
       	</ul>
       	as selected on this form.
       	<p>
       	Each withdrawal will correspond to a fixed amount equal to the total stated on this form.  
       	I understand my account will be debited two business days before the published delivery dates for my order frequency. 
       	</p>
       	</p>
       	<h4>WAIVER</h4>  
       	<p>
       	I hereby waive any and all requirements for pre-notification of debiting.  
       	I will receive a copy of this Agreement by email and waive all other confirmation before the first payment.  
       	</p>
       	<h4>SIGNATURES</h4>
       	<b>I guarantee that all persons whose signatures are required for this account have authorized this agreement.</b>

		<h4>CHANGE AND/OR CANCELLATION: </h4>

		<p>I will advise PAC of any changes to this Agreement including, without limitation, changes to my account number, 
		  by sending a written notice to PAC at grocerycards@nelsonwaldorf.org at least 10 business days prior to the next withdrawal. 
		I retain the right to revoke my authorization at any time, by sending a written notice to PAC at grocerycards@nelsonwaldorf.org 
		  at least 10 business days prior to the next withdrawal. 
		To obtain a sample of the cancellation form or for more information on my right to cancel a PAD Agreement, 
		I may contact my financial institution or consult the Canadian Payments Association at <a href="http://www.cdnpay.ca">www.cdnpay.ca</a>. 
		I agree to release the financial institution of any liability if the revocation is not respected, except in the case of gross negligence on its part. 
		I agree that the financial institution at which I maintain the account is not required to verify that the payment is debited in accordance with this authorization. 
		  I also certify that every person whose signature is required for the operation of the aforementioned account has signed this authorization.  
		I acknowledge that the delivery of this authorization to PAC constitutes delivery by me to the aforementioned financial institution.  
		</p>
		<h4>REIMBURSEMENT</h4>
		<p>                
		I have certain rights of recourse if a debit does not comply with the terms of this Agreement. For example, I have the right to receive reimbursement 
		for any PAD that is not authorized or that is not compatible with the terms of this PAD Agreement. For more information on my rights of recourse, 
		I may contact my financial institution or visit www.cdnpay.ca. The financial institution shall reimburse me, on behalf of the organization, for any 
		amounts withdrawn in error, within 90 calendar days of the withdrawal, provided that the reimbursement is claimed for a valid reason. I understand 
		that a claim to this effect must be made to my financial institution following the procedure it will provide for that purpose. Finally, I acknowledge 
		that a claim for reimbursement filed after the aforementioned time limits must be settled between me and PAC, without any liability or commitment on the 
		part of my financial institution.  
		</p>
		<h4>CONSENT TO DISCLOSURE OF INFORMATION</h4>
		<p>
		I hereby consent to the disclosure of the information contained in my pre- authorized debit enrolment agreement to the 
		financial institution, provided such information is directly related to and required for the smooth application of the rules governing pre-authorized debits.  
		</p>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@stop