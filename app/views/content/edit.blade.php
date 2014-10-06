@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit content</h2>
</div>
<div class="row">
    {{ Form::model($content, array('route' => array('content.update', $content->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('page_id', 'Page Id') }}
        {{ Form::text('page_id', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('section', 'Section') }}
        {{ Form::text('section', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('content', 'Content') }}
        {{ Form::text('content', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit Content', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

