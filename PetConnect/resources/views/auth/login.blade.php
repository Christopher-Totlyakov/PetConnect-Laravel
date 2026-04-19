@extends('layouts')

@section('title', 'Login')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6">

        <div class="card shadow-sm mt-5">
            <div class="p-5">

                <h2 class="mb-4 text-center">Login</h2>

                <form method="POST" action="{{ route('login') }}">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif                

                    <div class="form-group mb-3">
                        <input 
                            type="email" 
                            name="email" 
                            class="form-control" 
                            placeholder="Email"
                            required
                        >
                    </div>

                    <div class="form-group mb-3">
                        <input 
                            type="password" 
                            name="password" 
                            class="form-control" 
                            placeholder="Password"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        Login
                    </button>

                    <div class="mt-3 text-center">
                        Don't have an account?
                        <a href="{{ route('register') }}">Sign up here</a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection