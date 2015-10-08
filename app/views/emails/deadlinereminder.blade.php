<html>
<body>
	<h2>Hi {{{$user->name}}},</h2>
	
	<p>
		Need to change your grocery card order? You have until tomorrow, {{{$cutoff->cutoffdate()->subHour()->format('l, F jS')}}}, at midnight. 
		@if($user->saveon > 0 || $user->coop > 0 || $user->saveon_onetime > 0 || $user->coop_onetime > 0)
			If you do not change your order by then, your account will be debited or your credit card will be charged the amount of your order 
			on {{{$cutoff->chargedate()->format('l, F jS')}}}. 
		@endif
	</p>
	<p>
		You can change your regular order OR order extra cards <b>just once</b> 
		at <a href="https://grocerycards.nelsonwaldorf.org/edit">https://grocerycards.nelsonwaldorf.org/edit</a>. Heck, you could even do both!
		Log in with this email address and the password you signed up with. (Forgot your password? You can reset it at the login screen.) 
	</p>
	@if($user->saveon > 0 || $user->coop > 0)
		<p>
			You are currently ordering<br/>
			<b>${{{$user->coop}}}00 from Kootenay Co-op</b><br/>
			<b>${{{$user->saveon}}}00 from Save-On</b><br/>
		</p>	
	@endif
	@if($user->saveon_onetime > 0 || $user->coop_onetime > 0)
		<p>
			You have a <b>one-time</b> order for <br/>
			<b>${{{$user->coop_onetime}}}00 from Kootenay Co-op</b><br/>
			<b>${{{$user->saveon_onetime}}}00 from Save-On</b><br/>
		</p>
	@endif
	@if($user->saveon > 0 || $user->coop > 0 || $user->saveon_onetime > 0 || $user->coop_onetime > 0)
		<p>
			On {{{$cutoff->deliverydate()->format('l, F jS')}}}, your cards will be
			@if($user->deliverymethod)
				<b>mailed to you</b> at<br/>
				{{{$user->name}}}<br/>
					{{{$user->address1}}}<br/>
					{{{$user->address2?$user->address2 + '<br/>':''}}}
					{{{$user->city}}},
					{{{$user->province}}}<br/>
					{{{$user->postal_code}}}
			@else
				<b>available to be picked up at the school</b>
				@if(($user->pickupalt))
					by you or by <b>{{{$user->pickupalt}}}</b>
				@endif
			@endif
		</p>
	@endif
	<p>
		Thank you for your support,<br/>
		Snow Colbeck<br/>
	<p>NWS Grocery Cards Committee</p>
	</p>
</body>
</html>