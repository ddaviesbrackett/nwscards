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
		<script src="//openam.github.io/bootstrap-responsive-tabs/js/responsive-tabs.js"></script>
		@if(!empty($_ENV['ga_code']))
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', "{{$_ENV['ga_code']}}", 'auto');
		  ga('send', 'pageview');

		</script>
		@endif
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
					<ul class="nav navbar-nav navbar-left">
						<li><a href="/new">Order</a></li>
						@yield('nav-extra')
					</ul>
					<ul class="nav navbar-nav navbar-right">
						@if(Sentry::check())
							@if(Sentry::getUser()->isAdmin())
							<li class="admin-dropdown">
					          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <span class="caret"></span></a>
					          <ul class="dropdown-menu" role="menu">
								<li><a href="/admin/totals">Totals</a></li>
					            <li><a href="/admin/orders">Orders</a></li>
					            <li><a href="/tracking/leaderboard">Tracking</a></li>
					            <li><a href="/admin/impersonate">Change Another User</a></li>
					            <li><a href="/admin/expenses">Expenses</a></li>
					            <!--<li><a href="/admin/recordsale">Cash Sales</a></li>-->
					          </ul>
					        </li>
							@endif
							<li>
					          <a href="/account">My Account</a>
					        </li>
					        @if(Session::has('adminUser'))
								<li><a href="/admin/unimpersonate"><span class="glyphicon glyphicon-log-out"></span> Stop Impersonating</a></li>
							@else
								<li><a href="/logout">Log Out</a></li>
							@endif
						@else
							<li><a href="/login"><span class="glyphicon glyphicon-user"></span> Log In</a></li>
						@endif
					</ul>
				</div>
			</div>
		</header>
		@if($errors->tme->has('error'))
			<div class="modal fade" id="tokenerror">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title">Error</h4>
			      </div>
			      <div class="modal-body">
			        <p>{{{$errors->tme->first('error')}}}</p>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      </div>
			    </div>
			  </div>
			</div>
			<script>
				$(function(){
					$('#tokenerror').modal();
				});
			</script>
		@endif
		@yield('content')
		<div class='text-center footer'>
			We appreciate your support<br> This fundraiser is presented and adminstered by the <a href="mailto:grocerycards@nelsonwaldorf.org">Nelson Waldorf School Parent Association</a>
		</div>
		<script>
			fakewaffle.responsiveTabs(['xs', 'sm']);
		</script>
	</body>
</html>