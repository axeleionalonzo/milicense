@extends('app')

@section('content')

<div class="container-fluid" ng-app="licenseApp" ng-controller="loginController">

	<!-- Navbar wrapper -->
	<ul id="userdropdown" class="dropdown-content">
		<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
	</ul>
	<nav class="top-nav white">
		<div class="nav-container">
			<div class="nav-wrapper">
				<a href="#" data-activates="mobile-demo" class="button-collapse grey-text text-darken-3"><i class="material-icons">menu</i></a>
				<ul class="right hide-on-med-and-down default-text">
					<li><a href="{{ url('/') }}">Home</a></li>
					<li><a href="{{ url('/auth/login') }}">Login</a></li>
					<li><a href="{{ url('/auth/register') }}">Register</a></li>
				</ul>
				<ul class="side-nav default-text" id="mobile-demo">
					<li><a href="{{ url('/') }}">Home</a></li>
					<li><a href="{{ url('/auth/login') }}">Login</a></li>
					<li><a href="{{ url('/auth/register') }}">Register</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<!-- /Navbar wrapper -->

    <!-- Page Content -->
    <div class="contentbox container" id="page-content-wrapper content">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ old('name') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail Address</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Confirm Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Register
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
    <!-- /#page-content-wrapper -->

</div>

@endsection
