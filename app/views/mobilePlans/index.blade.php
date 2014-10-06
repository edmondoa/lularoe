@section('content')
<div class="row">
    <h1>All MobilePlans</h1>
    <a class="btn btn-success" href="{{ url('mobilePlans/create') }}">New</a>
</div>
<div class="row">
    <table class="table">
        <thead>
        <th>Name</th><th>Blurb</th><th>Description</th>
        </thead>
        <tbody>
        @foreach($mobilePlans as $mobilePlans)
        <tr>
            
            <td>
                <a href="{{ url('mobilePlans/'.$mobilePlans->id) }}">{{ $mobilePlans->name }}</a>
            </td>
            
            <td>
                <a href="{{ url('mobilePlans/'.$mobilePlans->id) }}">{{ $mobilePlans->blurb }}</a>
            </td>
            
            <td>
                <a href="{{ url('mobilePlans/'.$mobilePlans->id) }}">{{ $mobilePlans->description }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
