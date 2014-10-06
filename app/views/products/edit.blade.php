@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit products</h2>
</div>
<div class="row">
    {{ Form::model($products, array('route' => array('products.update', $products->id), 'method' => 'PUT')) }}

    
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
    

    {{ Form::submit('Edit Products', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

