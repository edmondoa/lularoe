@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit cart</h2>
</div>
<div class="row">
    {{ Form::model($cart, array('route' => array('cart.update', $cart->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('product_id', 'Product Id') }}
        {{ Form::text('product_id', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit Cart', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

