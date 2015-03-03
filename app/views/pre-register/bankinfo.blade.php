<div class="row onboarding">
    <div class="col-12">
        <center>
            <h2>Hello there, {{$user->first_name}}!</h2>
            <p class="onboarding">It's now time to add your banking info so you can get paid.<br/>
            </p>
        </center>
        <div class="row">
            <div class="col-md-8 col-lg-offset-2">
                    <div class="clearfix">
                        <h3 class="pull-left no-pull-xs">Banking Account Information</h3>
                    </div>
                    @include('_helpers.loading')
					<div class="media-body clearfix">
						<div class="row">
							<div class="col-md-12">
						<div class="form-group">
						{{ Form::label('Bank Name', 'bankname',['class'=>'control-label col-lg-4 col-sm-4 col-md-4']) }}
						<div class="col-lg-8 col-sm-8 col-md-8">
							<input name='bankname' class='form-control' type='text' ng-model='bank.name' ng-minlength="8" required/>
							<small>Must be at least 8 characters <span>Valid: @{{loginForm.password.$valid}}</span></small>
						</div>
						{{ Form::label('Account Type', 'accttype',['class'=>'control-label col-lg-4 col-sm-4 col-md-4']) }}
						<div class="col-lg-8 col-sm-8 col-md-8">
							<input name='accttype' class='form-control' type='text' ng-model='bank.accttype' ng-minlength="6" required/>
							<small>Must be at least 8 characters <span>Valid: @{{loginForm.password.$valid}}</span></small>
						</div>
						{{ Form::label('Routing Number', 'routnum',['class'=>'control-label col-lg-4 col-sm-4 col-md-4']) }}
						<div class="col-lg-8 col-sm-8 col-md-8">
							<input name='routnum' class='form-control' type='text' ng-model='bank.routnum' ng-minlength="6" required/>
							<small>Must be at least 8 characters <span>Valid: @{{loginForm.password.$valid}}</span></small>
						</div>
						{{ Form::label('Account Number', 'acctnum',['class'=>'control-label col-lg-4 col-sm-4 col-md-4']) }}
						<div class="col-lg-8 col-sm-8 col-md-8">
							<input name='acctnum' class='form-control' type='text' ng-model='bank.acctnum' ng-minlength="6" required/>
							<small>Must be at least 8 characters <span>Valid: @{{loginForm.password.$valid}}</span></small>
						</div>
                </div>
	
							</div>
						</div>
					</div>
            </div>
        </div>
    </div>
</div>
<div class="onboarding_form">
    <div class="row">
        <div class="col col-xl-3 col-lg-6 col-lg-offset-3 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
			<blockquote>Once you have added <b>all</b> your account information, please view our agreement and click "Save Info"</blockquote>
				<button ng-hide='next' type="button" class="pull-right btn btn-sm btn-success" ng-click="goto('/bankinfo')">Save Info</button>
        </div>
    </div>
</div>
