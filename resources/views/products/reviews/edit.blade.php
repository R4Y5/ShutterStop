@extends('layouts.app')

@section('content')
<style>
    /* Constraint for the form width */
    .form-wrapper {
        max-width: 600px;
        margin: 0 auto;
        padding: 40px 0;
    }

    /* Hero Title */
    .hero-text h2 {
        font-family: 'Inter', sans-serif;
        font-weight: 900;
        font-size: 2.2rem;
        line-height: 1.1;
        margin-bottom: 10px;
        text-align: center;
        text-transform: uppercase;
    }

    .product-highlight {
        display: block;
        text-align: center;
        font-weight: 800;
        text-transform: uppercase;
        color: #555;
        margin-bottom: 30px;
        font-size: 1.1rem;
    }

    /* Card Styling */
    .card-retro {
        background-color: #fff;
        border: 3px solid #000 !important;
        border-radius: 0 !important;
        box-shadow: 10px 10px 0px 0px #000;
        padding: 30px;
    }

    /* Form Labels */
    label {
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.85rem;
        margin-bottom: 8px;
        display: block;
    }

    /* Inputs & Textarea */
    .form-control, .form-select {
        border: 2px solid #000 !important;
        border-radius: 0 !important;
        padding: 12px;
        background-color: #fff;
        font-weight: bold;
    }

    .form-control:focus, .form-select:focus {
        box-shadow: 4px 4px 0px 0px #000;
        border-color: #000;
        outline: none;
    }

    /* The Button */
    .btn-retro-update {
        background-color: #ffff00 !important;
        color: #000 !important;
        border: 2px solid #000 !important;
        border-radius: 0 !important;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.2s;
        box-shadow: 6px 6px 0px 0px #000;
        padding: 15px 25px;
        width: 100%;
        margin-top: 20px;
    }

    .btn-retro-update:hover {
        background-color: #000 !important;
        color: #fff !important;
        box-shadow: none;
        transform: translate(3px, 3px);
    }

    .back-link {
        display: block;
        text-align: center;
        margin-top: 20px;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.8rem;
        color: #000;
        text-decoration: underline;
    }
</style>

<div class="container py-4">
    <div class="form-wrapper">
        <div class="hero-text">
            <h2>Edit Review.</h2>
            <span class="product-highlight">{{ $review->product->name }}</span>
        </div>

        <div class="card-retro">
            <form action="{{ route('account.reviews.update', $review->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label>Rating</label>
                    <select name="rating" class="form-select">
                        {{-- Shows current rating as the default label, but field is technically "blank" for a new choice --}}
                        <option value="{{ $review->rating }}" selected>Current: {{ $review->rating }} Stars (Keep Original)</option>
                        <option disabled>---------</option>
                        @for($i=1;$i<=5;$i++)
                            <option value="{{ $i }}">{{ $i }} / 5 Stars</option>
                        @endfor
                    </select>
                </div>

                <div class="mb-4">
                    <label>Your Comment</label>
                    {{-- Textarea is physically empty, but placeholder shows the old content --}}
                    <textarea name="comment"
                              class="form-control"
                              rows="6"
                              placeholder="Current Review: {{ $review->comment }}">{{ old('comment') }}</textarea>
                    <small class="text-muted mt-2 d-block">Leave blank to keep your current review text.</small>
                </div>

                <button type="submit" class="btn btn-retro-update">
                    Update My Review
                </button>
            </form>
        </div>

        <a href="{{ url()->previous() }}" class="back-link">Cancel & Go Back</a>
    </div>
</div>
@endsection
