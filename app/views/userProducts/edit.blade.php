@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit userProducts</h2>
</div>
<div class="row">
    {{ Form::model($userProducts, array('route' => array('userProducts.update', $userProducts->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('product_id', 'Product Id') }}
        {{ Form::text('product_id', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit UserProducts', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

