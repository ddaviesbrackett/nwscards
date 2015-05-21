<html>
<body>
	<h2>Hi {{{$user->name}}},</h2>
	
	<p>
		Summer holidays are fast approaching - and with it the last grocery card order of the year. 
		<b><a href="https://grocerycards.nelsonwaldorf.org/edit">Order extra cards</a> before midnight on Tuesday, May 26th to make sure you have plenty for the summer.</b>
	</p>
	<p>
	The Grocery Card Fairies are taking the summer off, but we'll be back in September. All regular orders will be suspended for the summer. 
	We'll let you know when you can reactivate so you don't miss an order.
	</p>
	<p>
		<b><a href="https://grocerycards.nelsonwaldorf.org/account/extracards">Add extra cards</a> to your order - 
		or <a href="https://grocerycards.nelsonwaldorf.org/edit">make a one-time order</a>.</b> 
		Just click the link - it's easy! (If you forget your password, you can reset it <a href="https://grocerycards.nelsonwaldorf.org/password/remind">here</a>.)
	</p>
	<p>
	Together we've <b>raised over $35,000</b> this school year. <b>Let's get to $40,000!</b>
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