@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $product->name }}</h1>
    <p><strong>Brand:</strong> {{ $product->brand }}</p>
    <p><strong>Category:</strong> {{ $product->category?->name ?? 'Uncategorized' }}</p>
    <p><strong>Description:</strong> {{ $product->description }}</p>
    <p><strong>Price:</strong> {{ $product->price }}</p>
    <p><strong>Stock:</strong> {{ $product->stock }}</p>

    @if($product->photo)
        <img src="{{ asset('storage/'.$product->photo) }}" width="150">
    @endif

    @if($product->photos->count())
        <div class="d-flex flex-wrap mt-3">
            @foreach($product->photos as $photo)
                <img src="{{ asset('storage/'.$photo->path) }}" width="100" class="m-1 rounded">
            @endforeach
        </div>
    @endif
</div>
@endsection
