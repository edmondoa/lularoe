@section('content')
<div class="row">
    <h2>New Payments</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'payments')) }}

    
    <div class="form-group">
        {{ Form::label('user_id', 'User Id') }}
        {{ Form::text('user_id', Input::old('user_id'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('transaction_id', 'Transaction Id') }}
        {{ Form::text('transaction_id', Input::old('transaction_id'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('amount', 'Amount') }}
        {{ Form::text('amount', Input::old('amount'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('tender', 'Tender') }}
        {{ Form::text('tender', Input::old('tender'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('details', 'Details') }}
        {{ Form::text('details', Input::old('details'), array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Add Payments', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop