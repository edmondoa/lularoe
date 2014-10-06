@section('content')
<div class="row">
    <h1>All EmailRecipients</h1>
    <a class="btn btn-success" href="{{ url('emailRecipients/create') }}">New</a>
</div>
<div class="row">
    <table class="table">
        <thead>
        <th>Sms Message Id</th><th>User Id</th>
        </thead>
        <tbody>
        @foreach($emailRecipients as $emailRecipients)
        <tr>
            
            <td>
                <a href="{{ url('emailRecipients/'.$emailRecipients->id) }}">{{ $emailRecipients->sms_message_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('emailRecipients/'.$emailRecipients->id) }}">{{ $emailRecipients->user_id }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
