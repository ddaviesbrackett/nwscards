<!doctype html>
<html>
	<head>
		<title>@yield('title',':D') &middot; NWS Grocery Cards</title>
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="/styles/layout.css" />
		<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
		<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		@yield('head-extra')
	</head>
	<body>
		<header class="navbar navbar-static-top mainnav" role="navigation">
  			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainnav-collapse">
				    <span class="sr-only">Toggle navigation</span>
				    <span class="icon-bar"></span>
				    <span class="icon-bar"></span>
				    <span class="icon-bar"></span>
				  </button>
				  <a class="navbar-brand" href="/">Grocery Cards</a>
				</div>
				<div class="collapse navbar-collapse" id="mainnav-collapse">
					<ul class="nav navbar-nav navbar-right">
						@yield('nav-extra')
						@if(Sentry::check())
							@if(Sentry::getUser()->isAdmin())
							<li class="dropdown">
					          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <span class="caret"></span></a>
					          <ul class="dropdown-menu" role="menu">
								<li><a href="/admin/totals">Totals</a></li>
					            <li><a href="/admin/orders">Orders</a></li>
					            <li><a href="/tracking/leaderboard">Tracking</a></li>
					          </ul>
					        </li>
							@endif
							<li><a href="/account">My Account</a></li>
							<li><a href="/logout">Log Out</a></li>
						@else
							<li><a href="/new">Order Cards</a></li>
							<li><a href="/login">Log In</a></li>
						@endif
					</ul>
				</div>
			</div>
		</header>
		@yield('content')
		<div class='text-center footer'>
			<hr/>
			We appreciate your support<br> This fundraiser is presented and adminstered by the <a href="mailto:grocerycards@nelsonwaldorf.org">Nelson Waldorf School Parent Association</a>
		</div>
	</body>
</html>