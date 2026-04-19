@extends('layouts')

@section('title', 'Sign Up - PetConnect')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6">

        <div class="card shadow-sm mt-5">
            <div class="p-5">

                <h2 class="text-center mb-4">Sign up 🐾</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group mb-3">
                        <input 
                            name="name" 
                            class="form-control" 
                            placeholder="Full name"
                            value="{{ old('name') }}"
                            required
                        >
                    </div>

                    <div class="form-group mb-3">
                        <input 
                            name="email" 
                            type="email"
                            class="form-control" 
                            placeholder="Email"
                            value="{{ old('email') }}"
                            required
                        >
                    </div>

                    <div class="form-group mb-3">
                        <input 
                            name="password" 
                            type="password" 
                            class="form-control" 
                            placeholder="Password"
                            required
                        >
                    </div>

                    <div class="form-group mb-3">
                        <input 
                            name="password_confirmation" 
                            type="password" 
                            class="form-control" 
                            placeholder="Confirm password"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        Sign up
                    </button>

                </form>

                <div class="text-center mt-3">
                    Have an account?
                    <a href="{{ route('login') }}">Sign in here</a>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection