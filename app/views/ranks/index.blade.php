@section('content')
<div class="row">
    <h1>All Ranks</h1>
    <a class="btn btn-success" href="{{ url('ranks/create') }}">New</a>
</div>
<div class="row">
    <table class="table">
        <thead>
        <th>Name</th>
        </thead>
        <tbody>
        @foreach($ranks as $ranks)
        <tr>
            
            <td>
                <a href="{{ url('ranks/'.$ranks->id) }}">{{ $ranks->name }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
