@section('content')
<div class="row">
    <h2>New Ranks</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'ranks')) }}

    
    <div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Add Ranks', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop