<html>
<body>
	<h2>Hi {{{$user->name}}},</h2>
	<p>
		You're not currently ordering grocery cards. If you'd like more cards, please order them by
		tomorrow, {{{$cutoff->cutoffdate()->format('l, F jS')}}}, at midnight. You can get cards just once, or sign up for a regular order.
	</p>
	<p>
		Order cards at <a href="https://grocerycards.nelsonwaldorf.org/edit">https://grocerycards.nelsonwaldorf.org/edit</a>.
		Log in with this email address and the password you signed up with. (Forgot your password? You can reset it at the login screen.) 
	</p>
	<p>
		Thank you for your support,<br/>
	<p>NWS Grocery Cards Committee</p>
	</p>
</body>
</html>