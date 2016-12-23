<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<title>@yield('title', "Laravel")</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->


	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">

	<link rel="stylesheet" href="{{ asset('/css/style.css') }}" />
</head>
<body>
	<a href="{{ url('home') }}"><div class="logo"></div></a>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('/') }}">Domov</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<!--<li><a href="{{ url('/') }}">Home</a></li> -->
						@if (Auth::check() and Auth::user()->is_active != '0')
							@if(Auth::user()->is_trainer)
								<li class="dropdown"><a href="{{ url('#') }}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="position: relative;">Groups  <span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										<li><a href="{{ url('createGroup') }}">create Group</a></li>
										<li><a href="{{ url('editGroup') }}">edit Group</a></li>
										<li><a href="{{ url('deleteGroup') }}">delete Group</a></li>
									</ul>
								</li>

								<li class="dropdown"><a href="{{ url('#') }}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="position: relative;">Running plans<span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										<li><a href="{{ route('running_plan.create') }}">create new Running plan</a></li>
										<li><a href="{{ route('running_plan.index') }}">list my Running plans</a></li>
									</ul>
								</li>

							@elseif(Auth::user()->is_admin)
								<li><a href="{{ url('addtrainers') }}">add Trainers</a></li>
								<li><a href="{{ url('/rmtrainers') }}">remove Trainers</a></li>
								<li><a href="{{ url('activate') }}">Activate User</a></li>
								<li><a href="{{ url('deleteUser') }}">Delete User</a></li>
							@else
								<li class="dropdown"><a href="{{ url('#') }}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="position: relative;">Running plans<span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										<li><a href="{{ route('running_plan.index') }}">list my Running plans</a></li>
									</ul>
								</li>

								<li><a href="{{ url('diary') }}">Zápisnik</a></li>
							@endif

						@endif
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest() or  Auth::user()->is_active == '0')
						<li><a href="{{ url('/auth/login') }}">Login</a></li>
						<li><a href="{{ url('/auth/register') }}">Register</a></li>

					@elseif (Auth::check() and Auth::user()->is_active !='0')

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="position: relative; padding-left: 50px;">
								<img src="/uploads/avatars/{{Auth::user()->avatar}}" style="width: 32px;height: 32px;border-radius:50%; position: absolute; top:10px;left: 10px;">
								{{ Auth::user()->name }} <span class="caret"></span>
							</a>

							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('profil') }}">Profil</a></li>
								<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	@yield('content')
</body>
<footer>
	<p>TEAM FSPH, FMFI UK &copy;2016<br> TIS projekt </p>
</footer>
</html>
