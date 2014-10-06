@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing reviews</h1>
    <a class="btn btn-primary" href="{{ url('reviews/'.$reviews->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'reviews/' . $reviews->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>Product Id:</th>
            <td>{{ $reviews->product_id }}</td>
        </tr>
        
        <tr>
            <th>Rating:</th>
            <td>{{ $reviews->rating }}</td>
        </tr>
        
        <tr>
            <th>Comment:</th>
            <td>{{ $reviews->comment }}</td>
        </tr>
        
    </table>
</div>
@stop
