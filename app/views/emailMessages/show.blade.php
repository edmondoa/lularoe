@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing emailMessages</h1>
    <a class="btn btn-primary" href="{{ url('emailMessages/'.$emailMessages->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'emailMessages/' . $emailMessages->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>Subject:</th>
            <td>{{ $emailMessages->subject }}</td>
        </tr>
        
        <tr>
            <th>Body:</th>
            <td>{{ $emailMessages->body }}</td>
        </tr>
        
    </table>
</div>
@stop
