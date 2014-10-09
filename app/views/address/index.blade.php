@section('content')
<div class="row">
    <h1>All Addresses</h1>
    <a class="btn btn-success" href="{{ url('address/create') }}">New</a>
    {{ Form::open(array('url' => 'addresses/' . 0, 'method' => 'POST')) }}
    <div class='input-group'>
        <select class="form-control selectpicker actions">
	    	<option value="address/disable" selected>Disable</option>
	    	<option value="address/enable" selected>Enable</option>
	    	<option value="address/delete" selected>Delete</option>
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
        		<th>Address 1</th><th>Address 2</th><th>City</th><th>State</th><th>Addressable Id</th><th>Zip</th><th>Disabled</th>
        	</tr>
        </thead>
        <tbody>
        @foreach($addresses as $address)
        <tr>
            <td><input class="bulk-check" type="checkbox" name="ids[]" value="{{ $address->id }}"></td>
            
            <td>
                <a href="{{ url('address/'.$address->id) }}">{{ $address->address_1 }}</a>
            </td>
            
            <td>
                <a href="{{ url('address/'.$address->id) }}">{{ $address->address_2 }}</a>
            </td>
            
            <td>
                <a href="{{ url('address/'.$address->id) }}">{{ $address->city }}</a>
            </td>
            
            <td>
                <a href="{{ url('address/'.$address->id) }}">{{ $address->state }}</a>
            </td>
            
            <td>
                <a href="{{ url('address/'.$address->id) }}">{{ $address->addressable_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('address/'.$address->id) }}">{{ $address->zip }}</a>
            </td>
            
            <td>
                <a href="{{ url('address/'.$address->id) }}">{{ $address->disabled }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
    {{ Form::close() }}
</div>
@stop
