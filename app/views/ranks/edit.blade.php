@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit ranks</h2>
</div>
<div class="row">
    {{ Form::model($ranks, array('route' => array('ranks.update', $ranks->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit Ranks', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

