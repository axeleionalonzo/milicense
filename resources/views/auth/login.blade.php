@extends('app')

@section('content')
<div class="container-fluid">

	<!-- Navbar wrapper -->
	<ul id="userdropdown" class="dropdown-content">
		<!-- <li><a href="{{ url('/auth/logout') }}">Logout</a></li> -->
	</ul>
	<nav class="top-nav white">
		<div class="nav-container">
			<div class="nav-wrapper">
				<a href="#" data-activates="mobile-demo" class="button-collapse grey-text text-darken-3"><i class="material-icons">menu</i></a>
				<ul class="right hide-on-med-and-down default-text">
					<li><a href="{{ url('/') }}">Home</a></li>
					<li><a href="{{ url('/auth/login') }}">Login</a></li>
					<!-- <li><a href="{{ url('/auth/register') }}">Register</a></li> -->
				</ul>
				<ul class="side-nav default-text" id="mobile-demo">
					<li><a href="{{ url('/') }}">Home</a></li>
					<li><a href="{{ url('/auth/login') }}">Login</a></li>
					<!-- <li><a href="{{ url('/auth/register') }}">Register</a></li> -->
				</ul>
			</div>
		</div>
	</nav>
	<!-- /Navbar wrapper -->

    <!-- Page Content -->
    <div class="contentbox" id="page-content-wrapper content">
        <div class="container-fluid">
            <div class="row">
				<div class="section no-pad-bot" id="index-banner">
					<div class="container col s12 m8 l4 offset-l4 offset-m2">
						<img class="geologo center-image" ng-src="{{ asset('/img/logo.png') }}">
						<h1 class="center amber-text text-accent-2 appname"><span class="amber-text text-darken-3">Market</span> <span class="indigo-text">Intel</span></h1>
						<div class="direcbox">
							<p class="center grey-text text-darken-2">Sign in to continue using Market Intel</p>
						</div>
					</div>
				</div>
				<div class="container">
					<div class="col s12 m8 l4 offset-l4 offset-m2">
						<div class="card">
							<div class="loginbox">
								<div class="card-content">
									<div class="greetingbox">
										<p class="center grey-text greetings">[[ greet ]]</p>
										<!-- <p id="geo-greeting" class="center grey-text greetings"></p> -->
									</div>
								</div>
								<div class="card-action">
									<!-- <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}"> -->
									<form class="form-horizontal" role="form">
										<input id="token"  type="hidden" name="_token" value="{{ csrf_token() }}">

										<div class="row loginform">
											<div class="form-group">
												<div class="col s12">
													<label for="email" class="email" data-error="Invalid Email">Email</label>
													<input id="email" type="email" name="email" class="validate" value="{{ old('email') }}">
												</div>
											</div>
											<div class="form-group">
												<div class="col s12 topmaginhide">
													<label for="password" class="password" data-error="wrong">Password</label>
													<input id="password" type="password" name="password" class="validate">
												</div>
											</div>
											
											<div class="form-group">
												<!-- <div class="col s12 checkbox topmaginhide">
													<input type="checkbox" class="filled-in" id="filled-in-box" name="remember" />
													<label for="filled-in-box">Remember Me</label>
												</div> -->
												<div class="input-field col s12">
													<button id="login" type="submit" class="waves-effect waves-light btn col s12 loginbutton indigo">Login</button>
													<!-- <a class="btn btn-link" href="{{ url('/password/email') }}">Forgot Your Password?</a> -->
												</div>
											</div>

											<div class="form-group">
												<div id="error" class="input-field col s12">
													@if (count($errors) > 0)
														<div class="alert alert-danger">
															<br>
															<div class="error-message error">
																<strong>Whoops!</strong> There were some problems with your input.<br><br>
																<ul>
																	@foreach ($errors->all() as $error)
																		<li>{{ $error }}</li>
																	@endforeach
																</ul>
															</div>
														</div>
													@endif
													<div class="alert alert-danger" ng-show="errorCode">
														<br>
														<div class="error-message error">
															<strong>Whoops!</strong> There were some problems with your input.<br><br>
															<ul>
																<li>[[ errorMessage ]]</li>
															</ul>
														</div>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
        <!-- forces the footer at the bottom if there is no content :D -->
    </div>
    <!-- /#page-content-wrapper -->

</div>
@endsection

@section('footer')
	<script type="text/javascript">
		$( document ).ready(function(){
		    $(".loginbox .card-action").fadeIn(1000);
		    $(".button-collapse").sideNav();
		});
	</script>
@endsection