@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit profiles</h2>
</div>
<div class="row">
    {{ Form::model($profiles, array('route' => array('profiles.update', $profiles->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('public_name', 'Public Name') }}
        {{ Form::text('public_name', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('public_content', 'Public Content') }}
        {{ Form::text('public_content', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('receive_company_email', 'Receive Company Email') }}
        {{ Form::text('receive_company_email', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('receive_company_sms', 'Receive Company Sms') }}
        {{ Form::text('receive_company_sms', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('receive_upline_email', 'Receive Upline Email') }}
        {{ Form::text('receive_upline_email', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('receive_upline_sms', 'Receive Upline Sms') }}
        {{ Form::text('receive_upline_sms', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('receive_downline_email', 'Receive Downline Email') }}
        {{ Form::text('receive_downline_email', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit Profiles', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

