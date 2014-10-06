@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit smsMessages</h2>
</div>
<div class="row">
    {{ Form::model($smsMessages, array('route' => array('smsMessages.update', $smsMessages->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('body', 'Body') }}
        {{ Form::text('body', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit SmsMessages', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

