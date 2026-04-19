@extends('layouts')

@section('title', 'Welcome')

@section('content')

<div class="jumbotron text-center">
    <img style="width:100%" src="https://activepets.co.za/web/ap-content/uploads/2019/08/Active-pets-dogs-and-cats.png">

    <h1 class="display-4 mt-3">Welcome to PetConnect 🐾</h1>
    <p class="lead">Share your pets photos ❣</p>

    @guest
        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login</a>
        <a href="{{ route('register') }}" class="btn btn-secondary btn-lg">Register</a>
    @endguest

</div>

@endsection