@section('content')
<div class="row">
    <h2>New Profiles</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'profiles')) }}

    
    <div class="form-group">
        {{ Form::label('public_name', 'Public Name') }}
        {{ Form::text('public_name', Input::old('public_name'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('public_content', 'Public Content') }}
        {{ Form::text('public_content', Input::old('public_content'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('receive_company_email', 'Receive Company Email') }}
        {{ Form::text('receive_company_email', Input::old('receive_company_email'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('receive_company_sms', 'Receive Company Sms') }}
        {{ Form::text('receive_company_sms', Input::old('receive_company_sms'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('receive_upline_email', 'Receive Upline Email') }}
        {{ Form::text('receive_upline_email', Input::old('receive_upline_email'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('receive_upline_sms', 'Receive Upline Sms') }}
        {{ Form::text('receive_upline_sms', Input::old('receive_upline_sms'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('receive_downline_email', 'Receive Downline Email') }}
        {{ Form::text('receive_downline_email', Input::old('receive_downline_email'), array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Add Profiles', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop