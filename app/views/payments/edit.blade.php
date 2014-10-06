@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit payments</h2>
</div>
<div class="row">
    {{ Form::model($payments, array('route' => array('payments.update', $payments->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('user_id', 'User Id') }}
        {{ Form::text('user_id', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('transaction_id', 'Transaction Id') }}
        {{ Form::text('transaction_id', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('amount', 'Amount') }}
        {{ Form::text('amount', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('tender', 'Tender') }}
        {{ Form::text('tender', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('details', 'Details') }}
        {{ Form::text('details', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit Payments', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

