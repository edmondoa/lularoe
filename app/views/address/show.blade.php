@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing address</h1>
    <a class="btn btn-primary" href="{{ url('address/'.$address->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'address/' . $address->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>Address 1:</th>
            <td>{{ $address->address_1 }}</td>
        </tr>
        
        <tr>
            <th>Address 2:</th>
            <td>{{ $address->address_2 }}</td>
        </tr>
        
        <tr>
            <th>City:</th>
            <td>{{ $address->city }}</td>
        </tr>
        
        <tr>
            <th>State:</th>
            <td>{{ $address->state }}</td>
        </tr>
        
        <tr>
            <th>Addressable Id:</th>
            <td>{{ $address->addressable_id }}</td>
        </tr>
        
        <tr>
            <th>Zip:</th>
            <td>{{ $address->zip }}</td>
        </tr>
        
        <tr>
            <th>Disabled:</th>
            <td>{{ $address->disabled }}</td>
        </tr>
        
    </table>
</div>
@stop
