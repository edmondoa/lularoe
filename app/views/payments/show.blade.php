@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing payments</h1>
    <a class="btn btn-primary" href="{{ url('payments/'.$payments->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'payments/' . $payments->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>User Id:</th>
            <td>{{ $payments->user_id }}</td>
        </tr>
        
        <tr>
            <th>Transaction Id:</th>
            <td>{{ $payments->transaction_id }}</td>
        </tr>
        
        <tr>
            <th>Amount:</th>
            <td>{{ $payments->amount }}</td>
        </tr>
        
        <tr>
            <th>Tender:</th>
            <td>{{ $payments->tender }}</td>
        </tr>
        
        <tr>
            <th>Details:</th>
            <td>{{ $payments->details }}</td>
        </tr>
        
    </table>
</div>
@stop
