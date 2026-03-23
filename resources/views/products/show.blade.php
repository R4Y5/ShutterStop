@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">{{ $product->name }}</h2>

    <div class="row">
        <!-- Main Photo -->
        <div class="col-md-6 text-center">
            <img id="mainPhoto"
                 src="{{ $product->photo ? asset('storage/' . $product->photo) : asset('images/default.png') }}"
                 alt="{{ $product->name }}"
                 style="width:600px; height:600px; object-fit:contain;">

            <!-- Gallery Thumbnails -->
            @if($product->photos->count() > 1)
                <div class="d-flex flex-wrap justify-content-center mt-3">
                    @foreach($product->photos as $photo)
                        <div class="m-2">
                            <img src="{{ asset('storage/' . $photo->path) }}"
                                 class="img-thumbnail"
                                 alt="{{ $product->name }}"
                                 style="width:80px; height:80px; object-fit:cover; cursor:pointer;"
                                 onclick="switchPhoto('{{ asset('storage/' . $photo->path) }}')">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <h4>₱{{ number_format($product->price, 2) }}</h4>
            <p>{{ $product->description }}</p>
            <p><strong>Brand:</strong> {{ $product->brand }}</p>
            <p><strong>Stock:</strong> {{ $product->stock }}</p>

            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Add to Cart</button>
            </form>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="mt-5">
        <h4>Customer Reviews</h4>
        @forelse($product->reviews as $review)
            <div class="border p-3 mb-2">
                <strong>{{ $review->user->name }}</strong>
                <span class="text-muted">rated {{ $review->rating }}/5</span>
                <p>{{ $review->comment }}</p>
            </div>
        @empty
            <p class="text-muted">No reviews yet.</p>
        @endforelse
    </div>
</div>

{{-- JS for switching photos --}}
<script>
function switchPhoto(newSrc) {
    const mainPhoto = document.getElementById('mainPhoto');
    mainPhoto.src = newSrc;
    mainPhoto.style.width = "600px";
    mainPhoto.style.height = "600px";
    mainPhoto.style.objectFit = "contain";
}
</script>
@endsection
