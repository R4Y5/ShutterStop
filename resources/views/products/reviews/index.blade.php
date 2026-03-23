@extends('layouts.app')

@section('content')
<div class="container">
    <h1>All Reviews</h1>
    <table id="reviews-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>User</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Date</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@section('scripts')
<script>
$('#reviews-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route('admin.reviews.data') }}',
    columns: [
        { data: 'id', name: 'id' },
        { data: 'product', name: 'product' },
        { data: 'user', name: 'user' },
        { data: 'rating', name: 'rating' },
        { data: 'comment', name: 'comment' },
        { data: 'created_at', name: 'created_at' }
    ]
});
</script>
@endsection
