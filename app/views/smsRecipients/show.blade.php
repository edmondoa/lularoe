@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing smsRecipients</h1>
    <a class="btn btn-primary" href="{{ url('smsRecipients/'.$smsRecipients->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'smsRecipients/' . $smsRecipients->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>Email Message Id:</th>
            <td>{{ $smsRecipients->email_message_id }}</td>
        </tr>
        
        <tr>
            <th>User Id:</th>
            <td>{{ $smsRecipients->user_id }}</td>
        </tr>
        
    </table>
</div>
@stop
