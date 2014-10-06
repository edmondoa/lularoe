@section('content')
<div class="row">
    <h2>New Cart</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'cart')) }}

    
    <div class="form-group">
        {{ Form::label('product_id', 'Product Id') }}
        {{ Form::text('product_id', Input::old('product_id'), array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Add Cart', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop