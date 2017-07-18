<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" />

	<title>Licenses</title>


	<!-- Styles -->
    @include('layout.style')
    
	@yield('header')

	<link rel="shortcut icon" href="{{ url('/favicon.ico') }}">
</head>
<body ng-app="licenseApp" ng-controller="mainController">

	<div id="[[ sidebarID ]]">

		@yield('content')

	    <!-- FOOTER -->
		<footer class="page-footer white footer">
			<div class="container">
				<div class="row valign-wrapper">
					<div class="valign col">
						<h5 class="default-text">MarketIntel</h5>
						<a href="#" class="black-text text-lighten-4">Version 3.0 License Portal</a>
					</div>
				</div>
			</div>
			<div class="footer-copyright">
				<div class="container black-text text-lighten-4">
					© 2017 All Rights Reserved
					<a class="black-text text-lighten-4 right" href="http://tecsq.com/">TEC Square Solutions Inc.</a>
				</div>
			</div>
		</footer>
	    <!-- /#FOOTER -->
	
	</div>

    <!-- Scripts -->
    @include('layout.script')

	@yield('footer')

</body>
</html>
