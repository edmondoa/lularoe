@section('content')
<div class="row">
    <h1>All Profiles</h1>
    <a class="btn btn-success" href="{{ url('profiles/create') }}">New</a>
</div>
<div class="row">
    <table class="table">
        <thead>
        <th>Public Name</th><th>Public Content</th><th>Receive Company Email</th><th>Receive Company Sms</th><th>Receive Upline Email</th><th>Receive Upline Sms</th><th>Receive Downline Email</th>
        </thead>
        <tbody>
        @foreach($profiles as $profiles)
        <tr>
            
            <td>
                <a href="{{ url('profiles/'.$profiles->id) }}">{{ $profiles->public_name }}</a>
            </td>
            
            <td>
                <a href="{{ url('profiles/'.$profiles->id) }}">{{ $profiles->public_content }}</a>
            </td>
            
            <td>
                <a href="{{ url('profiles/'.$profiles->id) }}">{{ $profiles->receive_company_email }}</a>
            </td>
            
            <td>
                <a href="{{ url('profiles/'.$profiles->id) }}">{{ $profiles->receive_company_sms }}</a>
            </td>
            
            <td>
                <a href="{{ url('profiles/'.$profiles->id) }}">{{ $profiles->receive_upline_email }}</a>
            </td>
            
            <td>
                <a href="{{ url('profiles/'.$profiles->id) }}">{{ $profiles->receive_upline_sms }}</a>
            </td>
            
            <td>
                <a href="{{ url('profiles/'.$profiles->id) }}">{{ $profiles->receive_downline_email }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
