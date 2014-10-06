@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing cart</h1>
    <a class="btn btn-primary" href="{{ url('cart/'.$cart->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'cart/' . $cart->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>Product Id:</th>
            <td>{{ $cart->product_id }}</td>
        </tr>
        
    </table>
</div>
@stop
