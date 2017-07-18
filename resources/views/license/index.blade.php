@extends('app')

@section('content')

<div>

	<!-- Sidebar -->
	<div id="sidebar-wrapper">
	    <ul class="sidebar-nav">
	        <li class="sidebar-brand">
	            <a href="{{ url('/') }}">
	                MarketIntel ™
	            </a>
	        </li>
			<li class="account"><a class="dropdown-button" href="#!" data-activates="sideuserdropdown"><i class="material-icons right account-drop">arrow_drop_down</i><small>[[ email ]]</small></a></li>
	        <li><a href="#" id="exportlicense"><i class="material-icons right account-drop">import_export</i>Export License</a></li>
	        <li><a href="#addLicenseModal" id="addlicense"><i class="material-icons right account-drop">add</i>Add License</a></li>
	        <li><a href="#genLicenseModal" id="genlicense"><i class="material-icons right account-drop">add_circle</i>Generate Licenses</a></li>
	    </ul>
		<ul id="sideuserdropdown" class="dropdown-content notop account-logout">
			<li><a id="logout">Logout</a></li>
		</ul>
	</div>
	<!-- /#sidebar-wrapper -->

	<!-- Navbar wrapper -->
	<ul id="userdropdown" class="dropdown-content">
		<li><a id="logout">Logout</a></li>
	</ul>
	<div class="navbar-fixed">
		<nav class="top-nav white shadow-1">
			<div class="nav-container">
				<div class="nav-wrapper">
					<div class="brand-logo">
						<a href="#menu-toggle" id="menu-toggle" class="default-text">
							<img class="nav-logo" ng-src="{{ asset('/img/logo.png') }}">
							Licenses
						</a>
					</div>
					<!-- Dropdown Trigger -->
					<ul class="pull-right default-text">
						<li><a class="dropdown-button" href="#!" data-activates="userdropdown">[[ email ]] <i class="material-icons right">arrow_drop_down</i></a></li>
					</ul>
				</div>
			</div>
		</nav>
	</div>
	<!-- /Navbar wrapper -->

	<!-- Page Content -->
	<div class="contentbox" id="page-content-wrapper content">
	    <div class="container-fluid">
	        <div class="row licenses">
				<div class="col s12">
					<div class="card">
						<div class="card-content">
							<span class="card-title">Summary</span>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ullamcorper orci ac risus suscipit congue ut vel ipsum. Vestibulum ac nibh sed lorem auctor ultrices. Donec sollicitudin aliquam neque ac posuere.</p>
						</div>
						<div class="card-tabs">
							<ul class="tabs tabs-fixed-width">
								<li class="tab"><a class="active" href="#general">General</a></li>
								<!-- <li class="tab"><a href="#test1">Organization</a></li>
								<li class="tab"><a href="#test2">Projects</a></li>
								<li class="tab"><a href="#test3">Licenses</a></li> -->
							</ul>
						</div>
						<div class="card-content">
							<div id="general">
								<div class="row center">
									<div class="col m4">
										<p class="licenseLabel">Licenses</p>
										<p class="licenseCount">[[ filteredLicense.length ]]</p>
									</div>
									<div class="col m4">
										<p class="licenseLabel">Active Licenses</p>
										<p class="licenseCount indigo-text">[[ (filteredLicense | filter:{status:1}).length ]]</p>
									</div>
									<div class="col m4">
										<p class="licenseLabel">Available Licenses</p>
										<p class="licenseCount green-text">[[ (filteredLicense | filter:{status:0}).length ]]</p>
									</div>
								</div>
							</div>
							<!-- <div id="test1">analytics 1</div>
							<div id="test2">analytics 2</div>
							<div id="test3">analytics 3</div> -->
						</div>
					</div>
				</div>

				<div class="col m12">
					<nav class="indigo searchbox">
						<div class="nav-wrapper">
							<form>
								<div class="input-field">
									<input id="search" type="search" ng-model="searchLicense" placeholder="[[ placeholder ]]" required>
									<label for="search"><i class="material-icons">search</i></label>
									<i ng-click="searchLicense = ''" class="material-icons">close</i>
								</div>
							</form>
						</div>
					</nav>
					<div class="row scrollbar">
						<licenses></licenses>
					</div>
				</div>

				<!-- MODALS -->
				<!-- add licenses modal -->
				<div id="addLicenseModal" class="addLicenseModal modal modal-fixed-footer bottom-sheet">
					<addlicense></addlicense>
				</div>
				<!-- generate licenses modal -->
				<div id="genLicenseModal" class="modal modal-fixed-footer bottom-sheet">
					<genlicense></genlicense>
				</div>
				<!-- confirm delete modal -->
				<div id="confirmDelete" class="modal modal-fixed-footer bottom-sheet">
					<deletelicense></deletelicense>
				</div>
				<!-- /#MODALS -->
	        </div>
	    </div>
	    <!-- forces the footer at the bottom if there is no content :D -->
	</div>
</div>
<!-- /#page-content-wrapper -->
@endsection

@section('footer')
	<script type="text/javascript">
		// initialize materialize js
		$( document ).ready(function(){
			$(".button-collapse").sideNav();
			$(".dropdown-button").dropdown();
			$(".modal").modal();
		});
	</script>
@endsection