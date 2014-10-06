@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit bonuses</h2>
</div>
<div class="row">
    {{ Form::model($bonuses, array('route' => array('bonuses.update', $bonuses->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('user_id', 'User Id') }}
        {{ Form::text('user_id', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('eight_in_eight', 'Eight In Eight') }}
        {{ Form::text('eight_in_eight', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('twelve_in_twelve', 'Twelve In Twelve') }}
        {{ Form::text('twelve_in_twelve', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit Bonuses', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

