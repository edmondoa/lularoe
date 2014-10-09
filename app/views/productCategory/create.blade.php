@section('content')
<div class="row">
    <h2>New ProductCategory</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'productCategory')) }}

    
    <div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('disabled', 'Disabled') }}
        {{ Form::text('disabled', Input::old('disabled'), array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Add ProductCategory', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop