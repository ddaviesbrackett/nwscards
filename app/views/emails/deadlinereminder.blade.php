<html>
<body>
	<h2>Hi {{{$user->name}}},</h2>
	<p>
		Need to change your grocery card order? You have until tomorrow, {{{$cutoff->cutoffdate()->format('l, F jS')}}},  at midnight.
	</p>
	<p>
		You can change your order at <a href="https://grocerycards.nelsonwaldorf.org/edit">https://grocerycards.nelsonwaldorf.org/edit</a>.
		Log in with this email address and the password you signed up with. (Forgot your pasword? You can reset it at the login screen.) 
	</p>
	@if($user->saveon > 0 || $user->coop > 0)
		<p>
			You are currently ordering<br/>
			<b>${{{$user->coop}}}00 from Kootenay Co-op</b><br/>
			<b>${{{$user->saveon}}}00 from Save-On</b><br/>
		</p>

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
	@else
		<p>You're not ordering any cards right now.</p>
	@endif
	<p>
		Thank you for your support,<br/>
		Donna Davies Brackett<br/>
	<p>NWS Grocery Cards Committee</p>
	</p>
</body>
</html>