@extends('layouts.default')
@section('content')
	<div ng-app ng-controller="PartyInviteController">
		@include('_helpers.breadcrumbs')
		<div class="row">
			<div class="col col-md-12">
				<h1>Invite {{ $user->first_name }} {{ $user->last_name }} to Host Your Party</h1>
			</div>
		</div>
		<div class="row">
			<div class="col col-md-6">
				<form action="/blast-party-host-invite" method="post">
					<input type="hidden" name="party_id" value="@include('_helpers.party_id')">
					<input type="hidden" name="user_id" value="{{ $user->id }}">
					@if (isset($leads))
						{{ Form::hidden('leads', $leads) }}
					@endif
				
					<!-- <div class="form-group">
						{{ Form::label('subject_line','To:')}}<br>
						<span>
							<input type='hidden' name='user_ids[]' value='{{ $user->id }}'>
							<span class="label label-default">{{ $user->first_name }} {{ $user->last_name }}</span>
						</span>
						<br>
						<small>(Users who have opted out of receiving emails will not be included.)</small>
					</div> -->
					
	                <div class="form-group" id="invite-to-party">
                        <select class="selectpicker pull-left margin-right-1" ng-change="getParty()" ng-model="selectedParty">
                        	<option value="" disabled selected>Select Party</option>
                            @foreach ($parties as $party)
                            	<option value="{{ $party->id }}">{{ date('M j', $party->date_start) }} - {{ substr($party->name, 0, 25) . ' ...'; }}</option>
                            @endforeach
                        </select>
	                </div>
					
	                <div class="clear"></div>
					
					<div id="message-form" style="display:none;">
				
						<!-- <div class="form-group">
							{{ Form::label('subject_line','*Subject:')}}
							{{ Form::text('subject_line',null,  $attributes = array('class'=>'form-control')) }}
						</div> -->

						<div class="panel panel-default">
							<div class="panel-heading">
								<h2 class="panel-title">Message Preview</h2>
							</div>
							<div class="panel-body">
								<table class="table">
									<tr>
										<th class="pull-right">To:</th>
										<td>{{ $user->first_name }} {{ $user->last_name }}</td>
									</tr>
									<tr>
										<th class="pull-right">From:</th>
										<td>{{ Auth::user()->full_name }}</td>
									</tr>
									<tr>
										<th class="pull-right">Subject:</th>
										<td>Invitation</td>
									</tr>
									<tr>
										<th class="pull-right">Body:</th>
										<td>
											<p>Dear [First Name],</p>
											<p>I'd like to invite you to host my {{ Config::get('site.company_name') }} party on <span ng-bind="party.date_start | date:'MMM d'"></span>.</p>
											<table class="table table-striped">
												<tr>
													<th style="width:0;">Event:</th>
													<td><span ng-bind="party.name"></span></td>
												</tr>
												<tr>
													<th>Date:</th>
													<td><span ng-bind="party.date_start | date:'MMM d, h:m a'"></span> - <span ng-bind="party.date_end | date:'h:m a'"></span></td>
												</tr>
												<tr ng-if="party.address">
													<th>Location:</th>
													<td>
													    <table>
													        <tr ng-if="party.address.label">
													            <td><span ng-bind="party.address.label"></span></td>
													        </tr>
													        <tr>
													            <td><span ng-bind="party.address.address_1"></span></td>
													        </tr>
													        <tr ng-if="party.address.address_2">
													            <td><span ng-bind="party.address.address_2"></span></td>
													        </tr>
													        <tr>
													            <td><span ng-bind="party.address.city"></span>, <span ng-bind="party.address.state"></span> <span ng-bind="party.address.zip"></span></td>
													        </tr>
													    </table>
													</td>
												</tr>
											</table>
											<p id="additional-notes"></p>
											<p>To learn more, you can call me at {{ Auth::user()->formatted_phone }}, respond to this email, or check out my store at: <a target="_blank" href="http://{{ Auth::user()->public_id }}.{{ Config::get('site.base_domain') }}">http://{{ Auth::user()->public_id }}.{{ Config::get('site.base_domain') }}</a>.</p>
											<label>Would you like to host this party?</label>
											<div>
												<button class="btn btn-primary" type="button">Yes</button> <button class="btn btn-primary" type="button">No</button>
											</div>
										</td>
									</tr>
								</table>
							</div>
						</div><!-- panel -->
						
						<div class="form-group">
							{{ Form::label('body','Additional Notes:')}}
							{{ Form::textarea('body', null,  $attributes = array('class'=>'form-control')) }}
						</div>
						
						<div class="form-group">
							{{ Form::submit('Send Invitations', ['class' => 'btn btn-primary']) }}
						</div>
					</div><!-- message-form -->
					
				{{ Form::close() }}
			</div>
		</div>
	</div>
@stop
@section('scripts')
	<script>
		
		function PartyInviteController($scope, $http) {
			$scope.getParty = function() {
				$('#invite-to-party').after('<img class="loading" src="/img/loading.gif" class="pull-left">');
				$http.get('/api/party/' + $scope.selectedParty).success(function(data) {
					console.log(data);
					$scope.party = data;
					$('.loading').remove();
					$('#message-form').slideDown();
				});
			}
		}
		
		$('textarea').keyup(function() {
			$('#additional-notes').html($(this).val());
		});
		
	</script>
@stop
