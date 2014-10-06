@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing profiles</h1>
    <a class="btn btn-primary" href="{{ url('profiles/'.$profiles->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'profiles/' . $profiles->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>Public Name:</th>
            <td>{{ $profiles->public_name }}</td>
        </tr>
        
        <tr>
            <th>Public Content:</th>
            <td>{{ $profiles->public_content }}</td>
        </tr>
        
        <tr>
            <th>Receive Company Email:</th>
            <td>{{ $profiles->receive_company_email }}</td>
        </tr>
        
        <tr>
            <th>Receive Company Sms:</th>
            <td>{{ $profiles->receive_company_sms }}</td>
        </tr>
        
        <tr>
            <th>Receive Upline Email:</th>
            <td>{{ $profiles->receive_upline_email }}</td>
        </tr>
        
        <tr>
            <th>Receive Upline Sms:</th>
            <td>{{ $profiles->receive_upline_sms }}</td>
        </tr>
        
        <tr>
            <th>Receive Downline Email:</th>
            <td>{{ $profiles->receive_downline_email }}</td>
        </tr>
        
    </table>
</div>
@stop
