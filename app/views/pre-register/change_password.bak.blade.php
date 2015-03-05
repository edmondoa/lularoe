<div class="row onboarding">
    <div class="col-12">
        <center>
            <h2>Hello there, {{$user->first_name}}!</h2>
            <p class="onboarding">Your email has been successfully verified. Please change your password below:<br/>
            </p>
        </center>
    </div>
</div>
<div class="onboarding_form">
    <div class="row">
        <div class="col col-xl-3 col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
                <form name='loginForm' class="full form-horizontal"> 
                {{ Form::hidden('sponsor_id', $sponsor->id) }}
                @if (isset($sponsor->id))
                    <div class="alert alert-success">@{{changepasswordForm.password.valid}}Your Sponsor is <strong>{{ $sponsor->first_name }} {{ $sponsor->last_name }}</strong></div>
                @endif                            
                <h2 class="no-top">Change Password</h2>
                
                
                <div class="form-group">
                    {{ Form::label('password', 'Password',['class'=>'control-label col-lg-4 col-sm-4 col-md-4']) }}
                    <div class="col-lg-8 col-sm-8 col-md-8">
                        <input name='password' class='form-control' type='password' ng-model='login.password' ng-minlength="8" required/>
                        <small>Must be at least 8 characters <span>Valid: @{{loginForm.password.$valid}}</span></small>
                    </div>
                </div>
                                
                <div class="form-group">
                    {{ Form::label('password_confirmation', 'Confirm Password',['class'=>'control-label col-lg-4 col-sm-4 col-md-4']) }}
                    <div class="col-lg-8 col-sm-8 col-md-8">
                        <input name='password_confirmation' class='form-control' type='password' ng-minlength="8" ng-model='login.password_confirmation' required/>
                        <small><span>Valid: @{{loginForm.password_confirmation.$valid}}</span></small>
                    </div>
                </div>
                
                <div class="form-group">
                    {{ Form::label('notice', 'You can login using',['class'=>'control-label col-lg-4 col-sm-4 col-md-4']) }}
                    <div class="col-lg-8 col-sm-8 col-md-8">
                        <div class="well alert alert-success">{{$user->email}}
                        </div>
                    </div>
                </div>

				<div class="clearfix pull-left">
					<span ng-if="checkPassMsg() && !isPassError" class="well alert alert-success">@{{changePasswd.message}}</span>
					<span ng-if="checkPassMsg()  && isPassError" class="well alert alert-danger">@{{changePasswd.message}}</span>
				</div>
                
                <button ng-hide="next"  ng-show='loginForm.password.$valid && loginForm.password_confirmation.$valid' type="button" class="pull-right btn btn-sm btn-info" ng-click="changepasswd()">Update</button>
                <button ng-show='next' type="button" class="pull-right btn btn-sm btn-primary" ng-click="goto('/products')">Next &raquo;</button>
                </form>
        </div>
    </div>
</div>