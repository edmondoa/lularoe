@section('content')
<div class="row">
    <h2>New Sales</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'sales')) }}

    
    <div class="form-group">
        {{ Form::label('product_id', 'Product Id') }}
        {{ Form::text('product_id', Input::old('product_id'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('user_id', 'User Id') }}
        {{ Form::text('user_id', Input::old('user_id'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('sponsor_id', 'Sponsor Id') }}
        {{ Form::text('sponsor_id', Input::old('sponsor_id'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('quantity', 'Quantity') }}
        {{ Form::text('quantity', Input::old('quantity'), array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Add Sales', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop