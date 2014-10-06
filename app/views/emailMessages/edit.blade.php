@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit emailMessages</h2>
</div>
<div class="row">
    {{ Form::model($emailMessages, array('route' => array('emailMessages.update', $emailMessages->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('subject', 'Subject') }}
        {{ Form::text('subject', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('body', 'Body') }}
        {{ Form::text('body', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit EmailMessages', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

