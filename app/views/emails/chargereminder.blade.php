<html>
<body>
	<h2>Hi {{{$user->name}}},</h2>
	<p> This is a reminder that you'll be charged for your grocery card order {{{$order->cutoffdate->chargedate()->format('l, F jS')}}}.</p>
	<p>
		You have ordered<br/>
		<b>${{{$order->coop + $order->coop_onetime}}}00 from Kootenay Co-op</b><br/>
		<b>${{{$order->saveon + $order->saveon_onetime}}}00 from Save-On</b><br/>
	</p>

	<p>
		On {{{$order->cutoffdate->deliverydate()->format('l, F jS')}}}, your cards will be
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
	<p>
		Thank you for your support,<br/>
		Donna Davies Brackett<br/>
		
	<p>NWS Grocery Cards Committee</p>
	</p>
</body>
</html>