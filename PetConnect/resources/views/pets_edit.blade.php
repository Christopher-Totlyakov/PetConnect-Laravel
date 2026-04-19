@extends('layouts')

@section('content')
<div class="container">
    <h2>Edit Pet</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pets.update', $pet->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label class="form-label">Pet name</label>
        <input 
            type="text" 
            name="name" 
            class="form-control mb-1"
            value="{{ old('name', $pet->name) }}"
        >
        @error('name')
            <div class="text-danger mb-2">{{ $message }}</div>
        @enderror

        <label class="form-label">Select type</label>
        <select name="type_id" class="form-control mb-1">
            @foreach($types as $type)
                <option 
                    value="{{ $type->id }}"
                    {{ old('type_id', $pet->type_id) == $type->id ? 'selected' : '' }}
                >
                    {{ $type->name }}
                </option>
            @endforeach
        </select>
        @error('type_id')
            <div class="text-danger mb-2">{{ $message }}</div>
        @enderror

        <label class="form-label">Age</label>
        <input 
            type="number" 
            name="age" 
            class="form-control mb-1"
            value="{{ old('age', $pet->age) }}"
        >
        @error('age')
            <div class="text-danger mb-2">{{ $message }}</div>
        @enderror

        <label class="form-label">Description</label>
        <textarea name="description" class="form-control mb-1">{{ old('description', $pet->description) }}</textarea>
        @error('description')
            <div class="text-danger mb-2">{{ $message }}</div>
        @enderror

        @if($pet->image)
            <label class="form-label">Current image</label>
            <div class="mb-2">
                <img src="{{ asset('storage/' . $pet->image->path) }}" width="200">
            </div>
        @endif

        <label class="form-label">Change image</label>
        <input type="file" name="image" class="form-control mb-1">
        @error('image')
            <div class="text-danger mb-2">{{ $message }}</div>
        @enderror

        <button class="btn btn-primary mt-2">
            Update Pet
        </button>
    </form>
</div>
@endsection