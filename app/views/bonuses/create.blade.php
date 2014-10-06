@section('content')
<div class="row">
    <h2>New Bonuses</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'bonuses')) }}

    
    <div class="form-group">
        {{ Form::label('user_id', 'User Id') }}
        {{ Form::text('user_id', Input::old('user_id'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('eight_in_eight', 'Eight In Eight') }}
        {{ Form::text('eight_in_eight', Input::old('eight_in_eight'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('twelve_in_twelve', 'Twelve In Twelve') }}
        {{ Form::text('twelve_in_twelve', Input::old('twelve_in_twelve'), array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Add Bonuses', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop