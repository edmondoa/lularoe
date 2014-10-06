@section('content')
<div class="row">
    <h1>All Reviews</h1>
    <a class="btn btn-success" href="{{ url('reviews/create') }}">New</a>
</div>
<div class="row">
    <table class="table">
        <thead>
        <th>Product Id</th><th>Rating</th><th>Comment</th>
        </thead>
        <tbody>
        @foreach($reviews as $reviews)
        <tr>
            
            <td>
                <a href="{{ url('reviews/'.$reviews->id) }}">{{ $reviews->product_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('reviews/'.$reviews->id) }}">{{ $reviews->rating }}</a>
            </td>
            
            <td>
                <a href="{{ url('reviews/'.$reviews->id) }}">{{ $reviews->comment }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
