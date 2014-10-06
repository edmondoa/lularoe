@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing mobilePlans</h1>
    <a class="btn btn-primary" href="{{ url('mobilePlans/'.$mobilePlans->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'mobilePlans/' . $mobilePlans->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>Name:</th>
            <td>{{ $mobilePlans->name }}</td>
        </tr>
        
        <tr>
            <th>Blurb:</th>
            <td>{{ $mobilePlans->blurb }}</td>
        </tr>
        
        <tr>
            <th>Description:</th>
            <td>{{ $mobilePlans->description }}</td>
        </tr>
        
    </table>
</div>
@stop
