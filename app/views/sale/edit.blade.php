@extends('layouts.default')
@section('content')
<div class="edit">
	<div class="row">
		<div class="col col-md-12">
			<div class="breadcrumbs">
				<a href="/sales">&lsaquo; Back</a>
			</div>
		    <h1>Edit sale</h1>
		    {{ Form::model($sale, array('route' => array('sales.update', $sale->id), 'method' => 'PUT')) }}
		
		    
		    <div class="form-group">
		        {{ Form::label('product_id', 'Product Id') }}
		        {{ Form::text('product_id', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('user_id', 'User Id') }}
		        {{ Form::text('user_id', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('sponsor_id', 'Sponsor Id') }}
		        {{ Form::text('sponsor_id', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('quantity', 'Quantity') }}
		        {{ Form::text('quantity', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('disabled', 'Disabled') }}
		        {{ Form::text('disabled', null, array('class' => 'form-control')) }}
		    </div>
		    
		
		    {{ Form::submit('Update Sale', array('class' => 'btn btn-success')) }}
		
		    {{Form::close()}}
		</div>
	</div>
</div>
@stop

