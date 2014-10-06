@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing commissions</h1>
    <a class="btn btn-primary" href="{{ url('commissions/'.$commissions->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'commissions/' . $commissions->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>User Id:</th>
            <td>{{ $commissions->user_id }}</td>
        </tr>
        
        <tr>
            <th>Amount:</th>
            <td>{{ $commissions->amount }}</td>
        </tr>
        
        <tr>
            <th>Description:</th>
            <td>{{ $commissions->description }}</td>
        </tr>
        
    </table>
</div>
@stop
