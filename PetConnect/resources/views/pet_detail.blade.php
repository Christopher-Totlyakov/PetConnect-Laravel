@extends('layouts')

@section('content')
<div class="container mb-5">

    <div class="card mb-4 shadow-sm">
        <img 
            src="{{ asset('storage/' . $pet->image->path) }}" 
            class="card-img-top"
        >

        <div class="card-body">
            <h2>{{ $pet->name }}</h2>

            <p><strong>Type:</strong> {{ $pet->type->name }}</p>
            <p><strong>Age:</strong> {{ $pet->age }}</p>
            <p><strong>Description:</strong> {{ $pet->description }}</p>

            <p>
                <strong>Owner:</strong> 
                {{ $pet->user->name }} ({{ $pet->user->email }})
            </p>
        </div>

        <div class="card-footer">
            @if($isOwner)
                <a href="{{ route('pets.edit', $pet->id) }}" class="btn btn-warning">Edit</a>
                <form id="delete-form" action="{{ route('pets.destroy', $pet->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                        Delete
                    </button>
                    <a class="btn btn-success ml-2" href="{{ route('posts.create', $pet->id) }}">Create post</a>
                </form>
            @endif
        </div>
    </div>

    <h3>Posts</h3>

    @forelse($pet->posts as $post)
        <div class="card mb-3">

            @if($post->image)
                <img src="{{ asset('storage/' . $post->image->path) }}" class="card-img-top">
            @endif

            <div class="card-body">
                <h5>{{ $post->title }}</h5>
                <p>{{ $post->content }}</p>

                <small class="text-muted">
                    {{ $post->created_at }}
                </small>

                @if($isOwner)
                    <form id="delete-post-form-{{ $post->id }}"
                          action="{{ route('posts.destroy', $post->id) }}"
                          method="POST"
                          class="d-inline">
                        @csrf
                        @method('DELETE')
                        <br/>
                        <button type="button" class="btn btn-danger" onclick="confirmDeletePost('delete-post-form-{{ $post->id }}')">
                            Delete
                        </button>
                    </form>
                @endif

                <div class="mt-2">
                    <button class="btn btn-sm btn-outline-danger like-btn"
                            data-post-id="{{ $post->id }}">
                        ❤️ <span id="like-count-{{ $post->id }}">
                            {{ $post->likes->count() }}
                        </span>
                    </button>
                </div>
            </div>
        </div>

    @empty
        <p>No posts yet.</p>
    @endforelse

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmDelete() {
    Swal.fire({
        title: "Are you sure?",
        text: "This pet will be deleted permanently!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form').submit();
        }
    });
}
function confirmDeletePost(formId) {
    Swal.fire({
        title: "Are you sure?",
        text: "This post will be deleted permanently!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {

            const form = document.getElementById(formId);

            if (!form) {
                console.error("Form not found:", formId);
                return;
            }

            form.submit();
        }
    });
}

document.querySelectorAll('.like-btn').forEach(btn => {
    btn.addEventListener('click', function () {

        const postId = this.dataset.postId;

        fetch(`/posts/${postId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {

            const countEl = document.getElementById(`like-count-${postId}`);

            countEl.innerText = data.count;

            if (data.liked) {
                btn.classList.add('btn-danger');
                btn.classList.remove('btn-outline-danger');
            } else {
                btn.classList.remove('btn-danger');
                btn.classList.add('btn-outline-danger');
            }
        });
    });
});

</script>
@endsection