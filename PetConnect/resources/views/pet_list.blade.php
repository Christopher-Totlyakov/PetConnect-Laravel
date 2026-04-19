@extends('layouts')

@section('content')


@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="container mb-4">
    <h1 class="text-center mb-4">All Pet Photos</h1>

    <div class="row">
        @foreach($pets as $pet)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">

                    <img src="{{ asset('storage/' . $pet->image->path) }}"
                         class="card-img-top">

                    <div class="card-body">
                        <h5>
                            {{ $pet->type->name }} {{ $pet->name }}
                        </h5>

                        <p>{{ $pet->description }}</p>
                    </div>

                    <div class="card-footer">
                        <small>by {{ $pet->user->name }}</small>
                    </div>
                    <a href="{{ route('pets.show', $pet->id) }}" class="btn btn-primary">
                        See details
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
  {{ $pets->links() }}
@endsection