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
						{{ Form::label('bankname','Bank Name',['class'=>'control-label col-lg-4 col-sm-4 col-md-4']) }}
						<div class="col-lg-8 col-sm-8 col-md-8">
							<input name='bankname' placeholder="e.g. Chase Bank" class='form-control' type='text' ng-model='bank.name' ng-minlength="8" required/>
						</div>
						{{ Form::label('accttype','Account Type', ['class'=>'control-label col-lg-4 col-sm-4 col-md-4']) }}
						<div class="col-lg-8 col-sm-8 col-md-8">
							<select name="accttype" class="form-control">
								<Option default>Checking</option>
								<Option>Saving</option>
							</select>
						</div>
						{{ Form::label('routnum', 'Routing Number', ['class'=>'control-label col-lg-4 col-sm-4 col-md-4']) }}
						<div class="col-lg-8 col-sm-8 col-md-8">
							<input name='routnum' class='form-control' type='text' ng-model='bank.routnum' ng-minlength="6" required/>
						</div>
						{{ Form::label('acctnum', 'Account Number', ['class'=>'control-label col-lg-4 col-sm-4 col-md-4']) }}
						<div class="col-lg-8 col-sm-8 col-md-8">
							<input name='acctnum' class='form-control' type='text' ng-model='bank.acctnum' ng-minlength="6" required/>
						</div>
						{{ Form::label('dlstate', 'Driver Lic. State', ['class'=>'control-label col-lg-4 col-sm-4 col-md-4']) }}
						<div class="col-lg-8 col-sm-8 col-md-8">
							<input name='dlstate' style="width:3.5em" class='form-control' maxlength="2" type='text' ng-model='bank.dlstate' ng-minlength="6" required/>
						</div>
						{{ Form::label('dlnum', 'Driver Lic. Num', ['class'=>'control-label col-lg-4 col-sm-4 col-md-4']) }}
						<div class="col-lg-8 col-sm-8 col-md-8">
							<input name='dlnum' class='form-control' type='text' ng-model='bank.dlnum' ng-minlength="6" required/>
						</div>
						{{ Form::label('socsec', 'Social Security', ['class'=>'control-label col-lg-4 col-sm-4 col-md-4']) }}
						<div class="col-lg-8 col-sm-8 col-md-8">
							<input name='socsec' class='form-control' type='text' ng-model='bank.socsec' ng-minlength="6" required/>
						</div>
						<div class="col-lg-8 col-sm-8 col-md-8">
						{{ Form::checkbox('agree', 1, true,['class'=>'pull-left']) }}
						{{ Form::label('agree', 'I agree to the terms and conditions', ['class'=>'control-label col-lg-8 col-sm-8 col-md-8']) }}
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
