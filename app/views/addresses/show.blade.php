@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing addresses</h1>
    <a class="btn btn-primary" href="{{ url('addresses/'.$addresses->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'addresses/' . $addresses->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>Address 1:</th>
            <td>{{ $addresses->address_1 }}</td>
        </tr>
        
        <tr>
            <th>Address 2:</th>
            <td>{{ $addresses->address_2 }}</td>
        </tr>
        
        <tr>
            <th>City:</th>
            <td>{{ $addresses->city }}</td>
        </tr>
        
        <tr>
            <th>State:</th>
            <td>{{ $addresses->state }}</td>
        </tr>
        
        <tr>
            <th>Addressable Id:</th>
            <td>{{ $addresses->addressable_id }}</td>
        </tr>
        
        <tr>
            <th>Zip:</th>
            <td>{{ $addresses->zip }}</td>
        </tr>
        
    </table>
</div>
@stop
