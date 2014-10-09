@section('content')
<div class="row">
    <h1>All Roles</h1>
    <a class="btn btn-success" href="{{ url('role/create') }}">New</a>
    {{ Form::open(array('url' => 'roles/' . 0, 'method' => 'POST')) }}
    <div class='input-group'>
        <select class="form-control selectpicker actions">
	    	<option value="role/disable" selected>Disable</option>
	    	<option value="role/enable" selected>Enable</option>
	    	<option value="role/delete" selected>Delete</option>
        </select>
        <div class='input-group-btn'>
        	<button class="btn btn-default applyAction" disabled><i class='fa fa-check'></i></button>
        </div>
    </div>
</div>
<div class="row">
    <table class="table">
        <thead>
        	<tr>
        		<th><input type="checkbox"></th>
        		<th>Name</th><th>Disabled</th>
        	</tr>
        </thead>
        <tbody>
        @foreach($roles as $role)
        <tr>
            <td><input class="bulk-check" type="checkbox" name="ids[]" value="{{ $role->id }}"></td>
            
            <td>
                <a href="{{ url('role/'.$role->id) }}">{{ $role->name }}</a>
            </td>
            
            <td>
                <a href="{{ url('role/'.$role->id) }}">{{ $role->disabled }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
    {{ Form::close() }}
</div>
@stop
