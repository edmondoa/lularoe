@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing productCategory</h1>
    <a class="btn btn-primary" href="{{ url('productCategory/'.$productCategory->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'productCategory/' . $productCategory->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>Name:</th>
            <td>{{ $productCategory->name }}</td>
        </tr>
        
        <tr>
            <th>Disabled:</th>
            <td>{{ $productCategory->disabled }}</td>
        </tr>
        
    </table>
</div>
@stop
