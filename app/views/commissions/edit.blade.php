@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit commissions</h2>
</div>
<div class="row">
    {{ Form::model($commissions, array('route' => array('commissions.update', $commissions->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('user_id', 'User Id') }}
        {{ Form::text('user_id', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('amount', 'Amount') }}
        {{ Form::text('amount', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('description', 'Description') }}
        {{ Form::text('description', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit Commissions', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

