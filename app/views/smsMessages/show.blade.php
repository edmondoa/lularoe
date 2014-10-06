@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing smsMessages</h1>
    <a class="btn btn-primary" href="{{ url('smsMessages/'.$smsMessages->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'smsMessages/' . $smsMessages->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>Body:</th>
            <td>{{ $smsMessages->body }}</td>
        </tr>
        
    </table>
</div>
@stop
