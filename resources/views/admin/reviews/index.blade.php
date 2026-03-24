@extends('layouts.app')

@section('content')
<div class="container">
    <h2>All Reviews</h2>
    <table id="reviews-table" class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>User</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@endsection

@push('scripts')
<!-- DataTables CSS/JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    console.log('Initializing DataTable...'); // Debug log

    let table = $('#reviews-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.reviews.data') }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'product', name: 'product' },
            { data: 'user', name: 'user' },
            { data: 'rating', name: 'rating' },
            { data: 'comment', name: 'comment' },
            { data: 'created_at', name: 'created_at' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });

    // Handle delete button
    $(document).on('click', '.delete-review', function() {
        if(confirm('Are you sure you want to delete this review?')) {
            let id = $(this).data('id');
            $.ajax({
                url: '/admin/reviews/' + id,
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function() {
                    table.ajax.reload();
                    alert('Review deleted successfully');
                },
                error: function() {
                    alert('Failed to delete review');
                }
            });
        }
    });
});
</script>
@endpush
