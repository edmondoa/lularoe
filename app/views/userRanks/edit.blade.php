@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit userRanks</h2>
</div>
<div class="row">
    {{ Form::model($userRanks, array('route' => array('userRanks.update', $userRanks->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('user_id', 'User Id') }}
        {{ Form::text('user_id', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('rank_id', 'Rank Id') }}
        {{ Form::text('rank_id', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit UserRanks', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

