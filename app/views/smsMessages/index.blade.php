@section('content')
<div class="row">
    <h1>All SmsMessages</h1>
    <a class="btn btn-success" href="{{ url('smsMessages/create') }}">New</a>
</div>
<div class="row">
    <table class="table">
        <thead>
        <th>Body</th>
        </thead>
        <tbody>
        @foreach($smsMessages as $smsMessages)
        <tr>
            
            <td>
                <a href="{{ url('smsMessages/'.$smsMessages->id) }}">{{ $smsMessages->body }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
