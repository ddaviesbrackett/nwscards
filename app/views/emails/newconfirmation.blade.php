<html>
<body>
<h2>Hi {{{$user->name}}},</h2>
<p> Thank you very much for your grocery card order.  This email is to confirm your order.  Please reply to this email if anything here doesn't look right.</p>
<h2>Your recurring order</h2>
	<p>
		You have ordered<br/>
		<b>${{{$user->coop}}}00 from Kootenay Co-op</b><br/>
		<b>${{{$user->saveon}}}00 from Save-On</b><br/>
	</p>
	<p>
		<b style="text-transform:capitalize;">{{{$user->schedule}}}</b><br/>
	</p>

	<p>
		Your cards will be
		@if($user->deliverymethod)
			<b>mailed to you</b> at<br/>
			{{{$user->name}}}<br/>
				{{{$user->address1}}}<br/>
				{{{$user->address2?$user->address2 + '<br/>':''}}}
				{{{$user->city}}},
				{{{$user->province}}}<br/>
				{{{$user->postal_code}}}
		@else
			<b>picked up at the school</b> by you
			@if(($user->pickupalt))
					or by <b>{{{$user->pickupalt}}}</b>
			@endif
		@endif
	</p>
	@if(!$user->payment)
		<p>A copy of the Pre-Authorized Debit Agreement is attached to this email.</p>
	@endif
	<p>
		Thank you ever so much,<br/>
		The Nelson Waldorf School Grocery Card Fundraiser Staff
	</p>
</body>
</html>