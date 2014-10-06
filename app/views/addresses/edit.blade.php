@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit addresses</h2>
</div>
<div class="row">
    {{ Form::model($addresses, array('route' => array('addresses.update', $addresses->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('address_1', 'Address 1') }}
        {{ Form::text('address_1', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('address_2', 'Address 2') }}
        {{ Form::text('address_2', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('city', 'City') }}
        {{ Form::text('city', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('state', 'State') }}
        {{ Form::text('state', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('addressable_id', 'Addressable Id') }}
        {{ Form::text('addressable_id', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('zip', 'Zip') }}
        {{ Form::text('zip', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit Addresses', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

