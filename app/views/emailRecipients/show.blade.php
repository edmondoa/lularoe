@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing emailRecipients</h1>
    <a class="btn btn-primary" href="{{ url('emailRecipients/'.$emailRecipients->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'emailRecipients/' . $emailRecipients->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>Sms Message Id:</th>
            <td>{{ $emailRecipients->sms_message_id }}</td>
        </tr>
        
        <tr>
            <th>User Id:</th>
            <td>{{ $emailRecipients->user_id }}</td>
        </tr>
        
    </table>
</div>
@stop
