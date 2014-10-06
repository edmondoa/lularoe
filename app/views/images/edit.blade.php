@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit images</h2>
</div>
<div class="row">
    {{ Form::model($images, array('route' => array('images.update', $images->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('type', 'Type') }}
        {{ Form::text('type', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('url', 'Url') }}
        {{ Form::text('url', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit Images', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

