@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>

				<div class="panel-body">
					You are logged in!
					<br />
					<br />
				</div>
			</div>

			<div class="table-responsive">
				<table class="table table-bordered">

					<!-- On rows -->
					<th class="active">id</th>
					<th class="">activation code</th>
					<th class="">organization</th>
					<th class="">status</th>
					<th class="">device code</th>
					<th class="">project</th>
					<th class="">date</th>
					<!-- On cells (`td` or `th`) -->
					@foreach ($licenses as $license)
						@if($license->status == 1)
							<tr class="info">
						@else
							<tr>
						@endif
							<td class="active">{{ $license->id }}</td>
							<td class="">{{ $license->act_code }}</td>
							<td class="">{{ $license->organization }}</td>
							<td class="">{{ $license->status }}</td>
							<td class="">{{ $license->device_code }}</td>
							<td class="">{{ $license->project }}</td>
							<td class="">{{ $license->act_date }}</td>
						</tr>
					@endforeach
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
