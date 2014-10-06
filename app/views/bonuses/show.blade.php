@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing bonuses</h1>
    <a class="btn btn-primary" href="{{ url('bonuses/'.$bonuses->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'bonuses/' . $bonuses->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>User Id:</th>
            <td>{{ $bonuses->user_id }}</td>
        </tr>
        
        <tr>
            <th>Eight In Eight:</th>
            <td>{{ $bonuses->eight_in_eight }}</td>
        </tr>
        
        <tr>
            <th>Twelve In Twelve:</th>
            <td>{{ $bonuses->twelve_in_twelve }}</td>
        </tr>
        
    </table>
</div>
@stop
