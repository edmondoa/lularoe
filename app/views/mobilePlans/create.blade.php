@section('content')
<div class="row">
    <h2>New MobilePlans</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'mobilePlans')) }}

    
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
    

    {{ Form::submit('Add MobilePlans', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop