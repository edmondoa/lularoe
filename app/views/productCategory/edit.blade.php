@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit productCategory</h2>
</div>
<div class="row">
    {{ Form::model($productCategory, array('route' => array('productCategory.update', $productCategory->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('disabled', 'Disabled') }}
        {{ Form::text('disabled', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit ProductCategory', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

