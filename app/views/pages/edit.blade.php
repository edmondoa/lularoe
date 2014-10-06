@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit pages</h2>
</div>
<div class="row">
    {{ Form::model($pages, array('route' => array('pages.update', $pages->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('url', 'Url') }}
        {{ Form::text('url', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('type', 'Type') }}
        {{ Form::text('type', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('opportunity', 'Opportunity') }}
        {{ Form::text('opportunity', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit Pages', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

