@extends('layouts.public')
@section('content')
<div class="show">
	<div class="row">
		<div class="col col-md-6">
			@include('_helpers.breadcrumbs')
			<h1 class="no-top">{{ $event->name }}</h1>
			<br>
		    <table class="table">

		        @if ($event->local_start_date == $event->local_end_date)
			        <tr>
			            <th>Local Date/Time:</th>
			            <td>
			            	{{ $event->local_start_date }}, {{ $event->local_start_time }} - {{ $event->local_end_time }}
			            	<br>
			            	<small>This time has been adjusted for your local time zone from {{ $event->formatted_start_date }}, {{ $event->formatted_start_time }} - {{ $event->formatted_end_time }} ({{ $event->timezone }})</small>
			            </td>
			        </tr>
		        @else
			        <tr>
			        	<th>Local Start Time:</th>
			        	<td>{{ $event->local_start_date }}, {{ $event->local_start_time }}
			            	<br>
			            	<small>This time has been adjusted for your local time zone from {{ $event->formatted_start_date }}, {{ $event->formatted_start_time }} ({{ $event->timezone }})</small>
			        	</td>
			        </tr>
			        <tr>
			        	<th>Local End Time:</th>
			        	<td>{{ $event->local_end_date }}, {{ $event->local_end_time }}
			        		<br>
			            	<small>This time has been adjusted for your local time zone from {{ $event->formatted_end_date }}, {{ $event->formatted_end_time }} ({{ $event->timezone }})</small>
			        	</td>
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
