@extends('layouts.gray')
@section('content')
<div class="show">
	<div class="row">
		<div class="col col-md-6">
			@include('_helpers.breadcrumbs')
			<h1 class="no-top">{{ $event->name }}</h1>
		    <table class="table">

		        @if ($event->local_start_date == $event->local_end_date)
			        <tr>
			            <th>Local Date/Time:</th>
			            <td>{{ $event->local_start_date }}, {{ $event->local_start_time }} - {{ $event->local_end_time }}</td>
			        </tr>
		        @else
			        <tr>
			        	<th>Local Start Time:</th>
			        	<td>{{ $event->local_start_date }}, {{ $event->local_start_time }}</td>
			        </tr>
			        <tr>
			        	<th>Local End Time:</th>
			        	<td>{{ $event->local_end_date }}, {{ $event->local_end_time }}</td>
			        </tr>
		        @endif
		        <!-- @if ($event->timezone != '')
		        	<tr>
		        		<th>Time Zone:</th>
		        		<td>{{ $event->timezone }}</td>
		        	</tr>
		        @endif -->
		        <tr>
		            <th>Description:</th>
		            <td>{{ $event->description }}</td>
		        </tr>

		    </table>
		</div>
	</div>
</div>
@stop
