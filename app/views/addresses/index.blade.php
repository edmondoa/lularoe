@section('content')
<div class="row">
    <h1>All Addresses</h1>
    <a class="btn btn-success" href="{{ url('addresses/create') }}">New</a>
</div>
<div class="row">
    <table class="table">
        <thead>
        <th>Address 1</th><th>Address 2</th><th>City</th><th>State</th><th>Addressable Id</th><th>Zip</th>
        </thead>
        <tbody>
        @foreach($addresses as $addresses)
        <tr>
            
            <td>
                <a href="{{ url('addresses/'.$addresses->id) }}">{{ $addresses->address_1 }}</a>
            </td>
            
            <td>
                <a href="{{ url('addresses/'.$addresses->id) }}">{{ $addresses->address_2 }}</a>
            </td>
            
            <td>
                <a href="{{ url('addresses/'.$addresses->id) }}">{{ $addresses->city }}</a>
            </td>
            
            <td>
                <a href="{{ url('addresses/'.$addresses->id) }}">{{ $addresses->state }}</a>
            </td>
            
            <td>
                <a href="{{ url('addresses/'.$addresses->id) }}">{{ $addresses->addressable_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('addresses/'.$addresses->id) }}">{{ $addresses->zip }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
