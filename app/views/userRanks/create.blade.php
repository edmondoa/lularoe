@section('content')
<div class="row">
    <h2>New UserRanks</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'userRanks')) }}

    
    <div class="form-group">
        {{ Form::label('user_id', 'User Id') }}
        {{ Form::text('user_id', Input::old('user_id'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('rank_id', 'Rank Id') }}
        {{ Form::text('rank_id', Input::old('rank_id'), array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Add UserRanks', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop