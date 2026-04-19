@extends('layouts')

@section('content')
<div class="container">
    <h2>Create Post for {{ $pet->name }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="pet_id" value="{{ $pet->id }}">

        <input type="text"
               name="title"
               class="form-control mb-1"
               placeholder="Title"
               value="{{ old('title') }}">

        @error('title')
            <div class="text-danger mb-2">{{ $message }}</div>
        @enderror

        <textarea name="content"
                  class="form-control mb-1"
                  placeholder="Content">{{ old('content') }}</textarea>

        @error('content')
            <div class="text-danger mb-2">{{ $message }}</div>
        @enderror

        <input type="file" name="image" class="form-control mb-1">

        @error('image')
            <div class="text-danger mb-2">{{ $message }}</div>
        @enderror

        <button class="btn btn-success mt-2">
            Create Post
        </button>
    </form>
</div>
@endsection