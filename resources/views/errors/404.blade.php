<html>
	<head>
		<link href='//fonts.googleapis.com/css?family=Lato:300,100' rel='stylesheet' type='text/css'>
		<title>Geointel</title>

		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #B0BEC5;
				display: table;
				font-weight: 100;
				font-family: 'Lato';
			}

			.container {
				text-align: center;
				display: table-cell;
				vertical-align: middle;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title {
				font-size: 72px;
				margin-bottom: 40px;
			}

			.geoerror {
				max-width: 100px;
			}

			.message {
				font-weight: 300;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<div class="row valign-wrapper">
					<div class="valign col s3">
						<a href="{{ url('/') }}">
							<img class="geoerror" src="{{ asset('/img/logo.png') }}">
						</a>
					</div>
				</div>
				<div class="title">That's wierd..</div>
				<p class="message">404: You must have entered a wrong link!</p>
			</div>
		</div>
	</body>
</html>
