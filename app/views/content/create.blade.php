@section('content')
<div class="row">
    <h2>New Content</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'content')) }}

    
    <div class="form-group">
        {{ Form::label('page_id', 'Page Id') }}
        {{ Form::text('page_id', Input::old('page_id'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('section', 'Section') }}
        {{ Form::text('section', Input::old('section'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('content', 'Content') }}
        {{ Form::text('content', Input::old('content'), array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Add Content', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop