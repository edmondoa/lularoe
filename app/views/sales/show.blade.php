@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing sales</h1>
    <a class="btn btn-primary" href="{{ url('sales/'.$sales->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'sales/' . $sales->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>Product Id:</th>
            <td>{{ $sales->product_id }}</td>
        </tr>
        
        <tr>
            <th>User Id:</th>
            <td>{{ $sales->user_id }}</td>
        </tr>
        
        <tr>
            <th>Sponsor Id:</th>
            <td>{{ $sales->sponsor_id }}</td>
        </tr>
        
        <tr>
            <th>Quantity:</th>
            <td>{{ $sales->quantity }}</td>
        </tr>
        
    </table>
</div>
@stop
