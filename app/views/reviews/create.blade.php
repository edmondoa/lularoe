@section('content')
<div class="row">
    <h2>New Reviews</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'reviews')) }}

    
    <div class="form-group">
        {{ Form::label('product_id', 'Product Id') }}
        {{ Form::text('product_id', Input::old('product_id'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('rating', 'Rating') }}
        {{ Form::text('rating', Input::old('rating'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('comment', 'Comment') }}
        {{ Form::text('comment', Input::old('comment'), array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Add Reviews', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop