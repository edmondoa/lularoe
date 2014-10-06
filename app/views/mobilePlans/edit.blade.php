@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit mobilePlans</h2>
</div>
<div class="row">
    {{ Form::model($mobilePlans, array('route' => array('mobilePlans.update', $mobilePlans->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('blurb', 'Blurb') }}
        {{ Form::text('blurb', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('description', 'Description') }}
        {{ Form::text('description', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit MobilePlans', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

