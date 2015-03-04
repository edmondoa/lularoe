<div class="row onboarding">
    <div class="row">
        <div class="col col-xl-3 col-lg-6 col-lg-offset-3 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
            @include('_helpers.breadcrumbs')
            <h1 class="no-top">Payment Bank Account Information</h1>
            <!-- {{ Form::open(array('url' => '/bankinfo')) }} -->
			<form method="post" action="/bankinfo">

			<input type="hidden" name="onboard_finalstep" value="true">

            <div class="form-group">
                {{ Form::label('bank_name', 'Bank Name') }}
                {{ Form::text('bank_name', null, array('class' => 'form-control','placeholder'=>'e.g. Chase Bank')) }}
            </div>

            <div class="form-group">
                {{ Form::label('bank_routing', 'Routing #') }}
                {{ Form::text('bank_routing', null, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('bank_account', 'Account #') }}
                {{ Form::text('bank_account', null, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('license_state', 'Driver License State') }}
                {{ Form::text('license_state', null, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('license_number', 'Driver License Number') }}
                {{ Form::text('license_number', null, array('class' => 'form-control')) }}
            </div>
			<div class="col col-xl-3 col-lg-6 col-lg-offset-3 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
			{{ Form::checkbox('agree', 1, true,['class'=>'pull-left']) }}
			<label for="agree" class="control-label">I agree to the <a href="/terms-conditions" target="_BLANK">terms and conditions<a/></label>
			</div>

        </div>
    </div>
    <div class="row">
        <div class="col col-xl-3 col-lg-6 col-lg-offset-3 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
            <blockquote>Once you have added <b>all</b> your account information, please view our agreement and click "Save Info"</blockquote>
			{{ Form::submit('Update Bank Info', array('class' => 'btn btn-info pull-right')) }}
        </div>
    </div>
	{{Form::close()}}
</div>

