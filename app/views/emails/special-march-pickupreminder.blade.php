<html>
<body>
	<h2>Hi {{{$user->name}}},</h2>
	<p>As this coming Wednesday is a school holiday, your cards will be available for pick-up on the following Monday, which is <b>Monday, March 30</b>.</p>
	<p>You may have received a previous email saying it would be Wednesday; sorry about that.</p>
	<p>Please pick-up your cards on Monday, March 30 at the bottom of the stairs between 8-8:30 am or between 2:30-3 pm. As always you
	@if(($user->pickupalt))
	or your designated alternate ({{{$user->pickupalt}}})
	@endif
	will need to sign for the cards. </p>

	<p>Thank you for your support,<br/>
	<p>NWS Grocery Cards Committee</p>
</body>
</html>