@extends('layouts.app')

@section('content')
<style>
    /* Constraint for the form width */
    .form-wrapper {
        max-width: 600px;
        margin: 0 auto;
        padding: 40px 0;
    }

    /* Hero Title - Matching Security Page */
    .hero-text h2 {
        font-family: 'Inter', sans-serif;
        font-weight: 900;
        font-size: 2.2rem;
        line-height: 1.1;
        margin-bottom: 30px;
        text-align: center;
        text-transform: uppercase;
    }

    .product-name-highlight {
        display: block;
        color: #555;
        font-size: 1.2rem;
        margin-top: 10px;
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
        font-size: 0.9rem;
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

    /* The Button - Matching btn-retro */
    .btn-retro-submit {
        background-color: #ffff00 !important; /* Retro Yellow */
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

    .btn-retro-submit:hover {
        background-color: #000 !important;
        color: #fff !important;
        box-shadow: none;
        transform: translate(3px, 3px);
    }

    /* Optional: placeholder styling */
    textarea::placeholder {
        color: #aaa;
        font-weight: normal;
    }
</style>

<div class="container py-4">
    <div class="form-wrapper">
        <div class="hero-text">
            <h2>Write a Review.</h2>
            <span class="product-name-highlight">FOR: {{ $product->name }}</span>
        </div>

        <div class="card-retro">
            <form action="{{ route('products.review', $product->id) }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">

                <div class="mb-4">
                    <label>How would you rate it?</label>
                    <select name="rating" class="form-select" required>
                        <option value="" selected disabled>Select a rating...</option>
                        @for($i=1;$i<=5;$i++)
                            <option value="{{ $i }}">{{ $i }} / 5 Stars</option>
                        @endfor
                    </select>
                </div>

                <div class="mb-4">
                    <label>Your Feedback</label>
                    <textarea name="comment"
                              class="form-control"
                              rows="5"
                              placeholder="Tell us what you think about this product..."></textarea>
                </div>

                <button type="submit" class="btn btn-retro-submit">
                    Submit My Review
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
