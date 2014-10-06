@section('content')
<div class="row">
    <h2>New Addresses</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'addresses')) }}

    
    <div class="form-group">
        {{ Form::label('address_1', 'Address 1') }}
        {{ Form::text('address_1', Input::old('address_1'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('address_2', 'Address 2') }}
        {{ Form::text('address_2', Input::old('address_2'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('city', 'City') }}
        {{ Form::text('city', Input::old('city'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('state', 'State') }}
        {{ Form::text('state', Input::old('state'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('addressable_id', 'Addressable Id') }}
        {{ Form::text('addressable_id', Input::old('addressable_id'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('zip', 'Zip') }}
        {{ Form::text('zip', Input::old('zip'), array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Add Addresses', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop