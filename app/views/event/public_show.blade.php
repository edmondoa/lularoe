@extends('layouts.gray')
@section('content')
<div class="show">
	<div class="row">
		<div class="col col-md-6">
			@include('_helpers.breadcrumbs')
			<h1 class="no-top">{{ $event->name }}</h1>
		    <table class="table">

		        @if ($event->formatted_start_date == $event->formatted_end_date)
			        <tr>
			            <th>Date/Time:</th>
			            <td>{{ $event->formatted_start_date }}, {{ $event->formatted_start_time }} - {{ $event->formatted_end_time }}</td>
			        </tr>
		        @else
			        <tr>
			            <th>Starting Time:</th>
			            <td>{{ $event->formatted_start_date }}, {{ $event->formatted_start_time }}</td>
			        </tr>
			        
			        <tr>
			            <th>Ending Time:</th>
			            <td>{{ $event->formatted_end_date }}, {{ $event->formatted_end_time }}</td>
			        </tr>
		        @endif
		        
		        <tr>
		            <th>Description:</th>
		            <td>{{ $event->description }}</td>
		        </tr>

		    </table>
		</div>
	</div>
</div>
@stop
