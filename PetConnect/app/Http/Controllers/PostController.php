<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\PetPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function create($petId)
    {
        $pet = Pet::findOrFail($petId);

        return view('posts_create', compact('pet'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'title' => 'required|min:2',
            'content' => 'required|min:2',
            'image' => 'nullable|image',
        ], [
            'title.required' => 'Title is required',
            'content.required' => 'Content is required',
            'image.image' => 'File must be an image',
        ]);

        $pet = Pet::findOrFail($request->pet_id);

        if ($pet->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized');
        }

        $post = PetPost::create([
            'pet_id' => $request->pet_id,
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');

            $post->image()->create([
                'path' => $path
            ]);
        }

        return redirect()
            ->route('pets.show', $request->pet_id)
            ->with('success', 'Post created successfully');
    }

    public function destroy($id)
    {
        $post = PetPost::findOrFail($id);

        $post->delete();

        return back()->with('success', 'Post deleted successfully');
    }
}
