@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing userRanks</h1>
    <a class="btn btn-primary" href="{{ url('userRanks/'.$userRanks->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'userRanks/' . $userRanks->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>User Id:</th>
            <td>{{ $userRanks->user_id }}</td>
        </tr>
        
        <tr>
            <th>Rank Id:</th>
            <td>{{ $userRanks->rank_id }}</td>
        </tr>
        
    </table>
</div>
@stop
