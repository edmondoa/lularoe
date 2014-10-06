@section('content')
<div class="row">
    <h1>All UserProducts</h1>
    <a class="btn btn-success" href="{{ url('userProducts/create') }}">New</a>
</div>
<div class="row">
    <table class="table">
        <thead>
        <th>Product Id</th>
        </thead>
        <tbody>
        @foreach($userProducts as $userProducts)
        <tr>
            
            <td>
                <a href="{{ url('userProducts/'.$userProducts->id) }}">{{ $userProducts->product_id }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
