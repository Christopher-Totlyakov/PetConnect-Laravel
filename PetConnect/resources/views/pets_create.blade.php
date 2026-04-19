@extends('layouts')

@section('content')
<div class="container">
    <h2>Create Pet</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label class="form-label">Pet name:</label>
        <input 
            type="text" 
            name="name" 
            class="form-control mb-1" 
            placeholder="Pet name"
            value="{{ old('name') }}"
        >
        @error('name')
            <div class="text-danger mb-2">{{ $message }}</div>
        @enderror

        <label class="form-label">Select type:</label>
        <select name="type_id" class="form-control mb-1">
            <option value="">Select type</option>
            @foreach($types as $type)
                <option 
                    value="{{ $type->id }}" 
                    {{ old('type_id') == $type->id ? 'selected' : '' }}
                >
                    {{ $type->name }}
                </option>
            @endforeach
        </select>
        @error('type_id')
            <div class="text-danger mb-2">{{ $message }}</div>
        @enderror

        <label class="form-label">Age:</label>
        <input 
            type="number" 
            name="age" 
            class="form-control mb-1" 
            placeholder="Age"
            value="{{ old('age') }}"
        >
        @error('age')
            <div class="text-danger mb-2">{{ $message }}</div>
        @enderror

        <label class="form-label">Description:</label>
        <textarea 
            name="description" 
            class="form-control mb-1"
            placeholder="Description"
        >{{ old('description') }}</textarea>
        @error('description')
            <div class="text-danger mb-2">{{ $message }}</div>
        @enderror

        <label class="form-label">Image:</label>
        <input type="file" name="image" class="form-control mb-1">
        @error('image')
            <div class="text-danger mb-2">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn btn-success mt-2">
            Create Pet
        </button>
    </form>
</div>
@endsection