<html>
<body>
<h2>Hi {{{$user->name}}},</h2>
<p> Thank you very much for your grocery card order.  This email is to confirm {{{$isChange?"the changes you just made to ":""}}}your order.  
	You can change your order at <a href="https://grocerycards.nelsonwaldorf.org/edit">https://grocerycards.nelsonwaldorf.org/edit</a>.
	Log in with this email address and the password you signed up with. (Forgot your password? You can reset it at the login screen.)</p>
@if( $user->saveon + $user->coop > 0 && $user->schedule != 'none')
	<h2>Your recurring order</h2>
	<p>
		You have a <b style="text-transform:capitalize;">{{{$user->getFriendlySchedule()}}}</b> order of<br/>
		@if($user->coop > 0)
			<b>${{{$user->coop}}}00 from Kootenay Co-op</b><br/>
		@endif
		@if($user->saveon > 0)
			<b>${{{$user->saveon}}}00 from Save-On</b>
		@endif
	</p>
	<p>You will be charged on <b>{{{$dates[$user->schedule]['charge']}}}</b>, by <b>{{{$user->isCreditCard()?'credit card':'direct debit'}}}</b> (last 4 digits {{{$user->last_four}}}).</p>
	<p>Your cards will be available on <b>{{{$dates[$user->schedule]['delivery']}}}</b>.</p>
@else
	<p>You have no recurring order. You'll make more money for the school if you order more cards!</p>
@endif
@if($user->saveon_onetime + $user->coop_onetime > 0 && $user->schedule_onetime != 'none')
	<h2>Onetime order</h2>
	<p>
		You have a <b style="text-transform:capitalize;">one-time</b> order of<br/>
		@if($user->coop_onetime > 0)
			<b>${{{$user->coop_onetime}}}00 from Kootenay Co-op</b><br/>
		@endif
		@if($user->saveon_onetime > 0)
			<b>${{{$user->saveon_onetime}}}00 from Save-On</b>
		@endif
	</p>
	<p>You will be charged on <b>{{{$dates[$user->schedule_onetime]['charge']}}}</b>, by <b>{{{$user->isCreditCard()?'credit card':'direct debit'}}}</b> (last 4 digits {{{$user->last_four}}}).</p>
	<p>Your cards will be available on <b>{{{$dates[$user->schedule_onetime]['delivery']}}}</b>.</p>
@endif

@if($user->schedule != 'none' || $user->schedule_onetime != 'none')
	Supporting:
	<ul style='list-style-type:none;padding-left:0;'>
		<li><b><a href="https://grocerycards.nelsonwaldorf.org/tracking/tuitionreduction">the Tuition Reduction Fund</a></b></li>
		@foreach ($user->classesSupported() as $class)
			<li><b><a href="https://grocerycards.nelsonwaldorf.org/tracking/{{{$class}}}">{{{User::className($class)}}}</a></b></li>
		@endforeach
	</ul>
	<p>
		Your cards are being
		@if($user->deliverymethod)
			<b>mailed to you</b> at<br/>
			<span class="text-left">
			{{{$user->name}}}<br/>
				{{{$user->address1}}}<br/>
				{{{$user->address2?$user->address2 + '<br/>':''}}}
				{{{$user->city}}},
				{{{$user->province}}}<br/>
				{{{$user->postal_code}}}
			</span>
		@else
			<b>picked up at the school</b> by you
			@if(($user->pickupalt))
					or by <b>{{{$user->pickupalt}}}</b>
			@endif
		@endif
	</p>
@endif
@if(!$user->payment)
	<p>A copy of the Pre-Authorized Debit Agreement is attached to this email.</p>
@endif
	<p>
		Thank you ever so much,<br/>
		The Nelson Waldorf School Grocery Card Fundraiser Staff
	</p>
</body>
</html>