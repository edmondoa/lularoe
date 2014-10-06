@section('content')
<div class="row">
    <h1>All SmsRecipients</h1>
    <a class="btn btn-success" href="{{ url('smsRecipients/create') }}">New</a>
</div>
<div class="row">
    <table class="table">
        <thead>
        <th>Email Message Id</th><th>User Id</th>
        </thead>
        <tbody>
        @foreach($smsRecipients as $smsRecipients)
        <tr>
            
            <td>
                <a href="{{ url('smsRecipients/'.$smsRecipients->id) }}">{{ $smsRecipients->email_message_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('smsRecipients/'.$smsRecipients->id) }}">{{ $smsRecipients->user_id }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
