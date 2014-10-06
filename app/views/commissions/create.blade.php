@section('content')
<div class="row">
    <h2>New Commissions</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'commissions')) }}

    
    <div class="form-group">
        {{ Form::label('user_id', 'User Id') }}
        {{ Form::text('user_id', Input::old('user_id'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('amount', 'Amount') }}
        {{ Form::text('amount', Input::old('amount'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('description', 'Description') }}
        {{ Form::text('description', Input::old('description'), array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Add Commissions', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop