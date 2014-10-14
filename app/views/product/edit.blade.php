@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit product</h2>
</div>
<div class="row">
    {{ Form::model($product, array('route' => array('product.update', $product->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('blurb', 'Blurb') }}
        {{ Form::text('blurb', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('description', 'Description') }}
        {{ Form::text('description', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('price', 'Price') }}
        {{ Form::text('price', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('quantity', 'Quantity') }}
        {{ Form::text('quantity', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('category_id', 'Category Id') }}
        {{ Form::text('category_id', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('disabled', 'Disabled') }}
        {{ Form::text('disabled', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit Product', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

