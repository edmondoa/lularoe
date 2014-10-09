@section('content')
<div class="row">
    <h1>All ProductCategories</h1>
    <a class="btn btn-success" href="{{ url('productCategory/create') }}">New</a>
    {{ Form::open(array('url' => 'productCategories/' . 0, 'method' => 'POST')) }}
    <div class='input-group'>
        <select class="form-control selectpicker actions">
	    	<option value="productCategory/disable" selected>Disable</option>
	    	<option value="productCategory/enable" selected>Enable</option>
	    	<option value="productCategory/delete" selected>Delete</option>
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
        @foreach($productCategories as $productCategory)
        <tr>
            <td><input class="bulk-check" type="checkbox" name="ids[]" value="{{ $productCategory->id }}"></td>
            
            <td>
                <a href="{{ url('productCategory/'.$productCategory->id) }}">{{ $productCategory->name }}</a>
            </td>
            
            <td>
                <a href="{{ url('productCategory/'.$productCategory->id) }}">{{ $productCategory->disabled }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
    {{ Form::close() }}
</div>
@stop
