@section('content')
<div class="row">
    <h1>All EmailMessages</h1>
    <a class="btn btn-success" href="{{ url('emailMessages/create') }}">New</a>
</div>
<div class="row">
    <table class="table">
        <thead>
        <th>Subject</th><th>Body</th>
        </thead>
        <tbody>
        @foreach($emailMessages as $emailMessages)
        <tr>
            
            <td>
                <a href="{{ url('emailMessages/'.$emailMessages->id) }}">{{ $emailMessages->subject }}</a>
            </td>
            
            <td>
                <a href="{{ url('emailMessages/'.$emailMessages->id) }}">{{ $emailMessages->body }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
