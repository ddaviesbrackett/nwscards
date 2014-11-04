<html>
<body>
	<h2>Hi {{{$user->name}}},</h2>
	<p>Please pick-up your cards on Wednesday at the bottom of the stairs between 8-8:30 am or between 2:30-3 pm. You
	@if(($user->pickupalt))
	or your designated alternate ({{{$user->pickupalt}}})
	@endif
	will need to sign for the cards. </p>

	<p>Thank you for your support,<br/>
	Donna Davies Brackett</p>

	<p>NWS Grocery Cards Committee</p>
</body>
</html>