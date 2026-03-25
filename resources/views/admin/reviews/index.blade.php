@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 font-mono">
    <div class="border-4 border-black p-4 mb-8 bg-green-400 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] inline-block">
        <h2 class="text-3xl font-black uppercase tracking-tighter italic">All Reviews</h2>
    </div>

    <div class="bg-white border-4 border-black shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] overflow-hidden p-4">
        <div class="table-responsive">
            <table id="reviews-table" class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-black text-white border-b-4 border-black">
                        <th class="p-3 uppercase font-black">ID</th>
                        <th class="p-3 uppercase font-black">Product</th>
                        <th class="p-3 uppercase font-black">User</th>
                        <th class="p-3 uppercase font-black">Rating</th>
                        <th class="p-3 uppercase font-black">Comment</th>
                        <th class="p-3 uppercase font-black text-nowrap">Created At</th>
                        <th class="p-3 uppercase font-black">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-black">
                    </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Customizing DataTables elements to match the Retro UI */
    .dataTables_wrapper .dataTables_filter input {
        border: 3px solid black !important;
        padding: 4px 8px !important;
        font-weight: bold !important;
        margin-bottom: 1rem;
        box-shadow: 4px 4px 0px 0px rgba(0,0,0,1);
    }
    .dataTables_wrapper .dataTables_length select {
        border: 3px solid black !important;
        font-weight: bold !important;
        box-shadow: 4px 4px 0px 0px rgba(0,0,0,1);
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #000 !important;
        color: white !important;
        border: 2px solid black !important;
        font-weight: bold;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border: 2px solid black !important;
        font-weight: bold !important;
        border-radius: 0 !important;
    }
</style>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    console.log('Initializing DataTable...');

    let table = $('#reviews-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.reviews.data') }}',
        // Optional: Wrap actions in the retro button class if your backend doesn't already
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
