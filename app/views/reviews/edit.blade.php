@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit reviews</h2>
</div>
<div class="row">
    {{ Form::model($reviews, array('route' => array('reviews.update', $reviews->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('product_id', 'Product Id') }}
        {{ Form::text('product_id', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('rating', 'Rating') }}
        {{ Form::text('rating', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('comment', 'Comment') }}
        {{ Form::text('comment', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit Reviews', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

