@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit sales</h2>
</div>
<div class="row">
    {{ Form::model($sales, array('route' => array('sales.update', $sales->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('product_id', 'Product Id') }}
        {{ Form::text('product_id', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('user_id', 'User Id') }}
        {{ Form::text('user_id', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('sponsor_id', 'Sponsor Id') }}
        {{ Form::text('sponsor_id', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('quantity', 'Quantity') }}
        {{ Form::text('quantity', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit Sales', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

