@section('content')
<div class="row">
    <h2>New Products</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'products')) }}

    
    <div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('blurb', 'Blurb') }}
        {{ Form::text('blurb', Input::old('blurb'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('description', 'Description') }}
        {{ Form::text('description', Input::old('description'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('price', 'Price') }}
        {{ Form::text('price', Input::old('price'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('quantity', 'Quantity') }}
        {{ Form::text('quantity', Input::old('quantity'), array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Add Products', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop