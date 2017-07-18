@extends('app')

@section('header')
	<style type="text/css">
		.bodeh {
			padding: 0;
			width: 100%;
			height: 100%;
			color: #B0BEC5;
			display: table;
			font-weight: 100;
			font-family: 'Lato';
		}
		.container-bodeh {
			height: 74vh;
			text-align: center;
			display: table-cell;
			vertical-align: middle;
		}
		.content-bodeh {
			text-align: center;
			display: inline-block;
		}
		.title-bodeh {
			display: none;
			font-size: 96px;
			margin-bottom: 40px;
		}
		.quote-bodeh {
			height: 40px;
			font-weight: 300;
			font-size: 24px;
		}
		.quote-bodeh #quote {
			display: none;
		}
		.market {
			color: #FFA000;
		}
		.intel {
			color: #3F51B5;
		}
	</style>
@endsection

@section('content')
	<nav class="top-nav white">
		<div class="nav-container">
			<div class="nav-wrapper">
				<ul class="right default-text">
					<li><a href="{{ url('/auth/login') }}">Login</a></li>
					<!-- <li><a href="{{ url('/auth/register') }}">Register</a></li> -->
				</ul>
			</div>
		</div>
	</nav>

	<div class="bodeh">
		<div class="container-bodeh">
			<div class="content-bodeh">
				<div class="title-bodeh"><span class="market">Market</span> <span class="intel">Intel</span></div>
				<div class="quote-bodeh">
					<div id="quote">
						{{ Inspiring::quote() }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('footer')
<script type="text/javascript">
	// initialize materialize js
	$( document ).ready(function(){
	    // for welcome page start
		$(".title-bodeh").fadeIn(1000);
		$("#quote").delay(1000).fadeIn(1000);
		// welcome page end
	});
</script>
@endsection

