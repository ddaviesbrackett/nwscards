<html>
<body style="font-family:sans-serif;">
	<h2>Hi {{{$user->name}}},</h2>
	<p><b>Your grocery card order has been suspended.</b> You will not be charged, and cards won't be delivered to you, until you resume your order.</p>
	<p>
	You can press this button when you're ready for more cards:
	<a style="display:block;margin:3em auto;padding:1em;text-align:center;max-width:25em;color:White;background-color:#a40016;border-radius:5px;" 
	href="https://grocerycards.nelsonwaldorf.org/email-resume?uid={{{$user->id}}}}&code={{{$user->reactivation_code}}}"><span style="font-size:2em;">Resume My Order</span></a>
	<p>You can also resume your order at <a href="https://grocerycards.nelsonwaldorf.org/Resume">https://grocerycards.nelsonwaldorf.org/Resume</a>.
	Log in with this email address and the password you signed up with. (Forgot your password? You can reset it at the login screen.)</p>

	<p>Thank you for your support,<br/>
	Snow Colbeck</p>

	<p>NWS Grocery Cards Committee</p>
</body>
</html>