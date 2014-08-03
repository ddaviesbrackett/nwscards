<!doctype html>
<html>
	<head>
		<title>@yield('title',':D') &middot; NWS Grocery Cards</title>
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="/styles/layout.css" />
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
				  <a class="navbar-brand" href="/">NWS Cards</a>
				</div>
				<div class="collapse navbar-collapse" id="mainnav-collapse">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="/account">My Account</a></li>
					</ul>
				</div>
			</div>
		</header>
		@yield('content')
	</body>
</html>