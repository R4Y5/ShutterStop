@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- First Name -->
<div class="row mb-3">
    <label for="first_name" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}</label>
    <div class="col-md-6">
        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror"
            name="first_name" value="{{ old('first_name') }}" required autocomplete="given-name" autofocus>
        @error('first_name')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<!-- Last Name -->
<div class="row mb-3">
    <label for="last_name" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}</label>
    <div class="col-md-6">
        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror"
            name="last_name" value="{{ old('last_name') }}" required autocomplete="family-name">
        @error('last_name')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>


                        <!-- Email -->
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        <!-- Contact Number -->
                        <div class="row mb-3">
                            <label for="contact_no" class="col-md-4 col-form-label text-md-end">{{ __('Contact Number') }}</label>
                            <div class="col-md-6">
                                <input id="contact_no" type="text" class="form-control @error('contact_no') is-invalid @enderror"
                                    name="contact_no" value="{{ old('contact_no') }}" required autocomplete="tel">
                                @error('contact_no')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="row mb-3">
                            <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>
                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                                    name="address" value="{{ old('address') }}" required autocomplete="street-address">
                                @error('address')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>


                        <!-- Profile Photo -->
                        <div class="row mb-3">
                            <label for="photo" class="col-md-4 col-form-label text-md-end">{{ __('Profile Photo') }}</label>
                            <div class="col-md-6">
                                <input id="photo" type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                                @error('photo')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        

                        <!-- Terms & Conditions -->
                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" name="terms" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the Terms & Conditions
                                    </label>
                                    @error('terms')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
