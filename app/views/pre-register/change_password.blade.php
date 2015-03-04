<div class="row onboarding">
    <div class="col col-md-12">
	    <div class="alert alert-success inline-block">
	    	Hello there, {{$user->first_name}}! Your email was successfully verified.
	    </div>
        <h1 class="no-top">Step 2: Create New Password</h1>
    </div>
</div>
<div class="onboarding_form">
	<form name='loginForm'>
	    <div class="row">
	        <div class="col col-xl-3 col-lg-4 col-md-6 col-sm-6">
	                {{ Form::hidden('sponsor_id', $sponsor->id) }}
	                
	                <div class="form-group">
	                    {{ Form::label('password', 'Password') }}
	                    <input name='password' class='form-control' type='password' ng-model='login.password' ng-minlength="8" required/>
	                    <small>Must be at least 8 characters (<span>Valid: @{{loginForm.password.$valid}}</span>)</small>
	                </div>
	                                
	                <div class="form-group">
	                    {{ Form::label('password_confirmation') }}
	                    <input name='password_confirmation' class='form-control' type='password' ng-minlength="8" ng-model='login.password_confirmation' required/>
	                    <!-- <small><span>Valid: @{{loginForm.password_confirmation.$valid}}</span></small> -->
	                </div>
	                
	                <!-- <div class="form-group">
	                    {{ Form::label('notice', 'You can login using') }}
	                    <div class="well alert alert-success">{{$user->email}}
	                    </div>
	                </div> -->
			</div><!-- col -->
		</div><!-- row -->
		<div class="row">
			<div class="col col-md-12">
				
				<div class="form-group">
					<div ng-if="checkPassMsg() && !isPassError" class="alert alert-success inline-block">@{{changePasswd.message}}</div>
					<div ng-if="checkPassMsg()  && isPassError" class="alert alert-danger inline-block">@{{changePasswd.message}}</div>
				</div>
				
				<div class="form-group">
	                <button ng-hide="next" ng-show='loginForm.password.$valid && loginForm.password_confirmation.$valid' type="button" class="btn btn-primary" ng-click="changepasswd()">Next <i class="fa fa-angle-right"></i></button>
	                <button ng-show='next' type="button" class="btn btn-primary" ng-click="goto('/products')">Next <i class="fa fa-angle-right"></i></button>
				</div>
			
			</div><!-- col -->
		</div><!-- row -->
    </form>
</div>