<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\PetImage;
use App\Models\PetType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    public function list()
    {
        $pets = Pet::with(['type', 'image', 'user'])->latest()->paginate(6);

        return view('pet_list', compact('pets'));
    }

    public function create()
    {
        $types = PetType::all();

        return view('pets_create', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2',
            'type_id' => 'required',
            'image' => 'required|image',
            'age' => 'required|integer|min:1',
        ], [
            'name.required' => 'Pet name is required',
            'type_id.required' => 'Please select a type',
            'image.required' => 'Image is required',
            'image.image' => 'File must be an image',
            'age.min' => 'Age must be at least 1',
        ]);

        $path = $request->file('image')->store('pets', 'public');

        $image = PetImage::create([
            'path' => $path
        ]);

        Pet::create([
            'user_id' => Auth::id(),
            'type_id' => $request->type_id,
            'name' => $request->name,
            'age' => $request->age,
            'description' => $request->description,
            'image_id' => $image->id
        ]);

        return redirect()->route('pets.list')
            ->with('success', 'Pet created successfully');
    }

    public function show($id)
    {
        $pet = Pet::with([
            'type',
            'image',
            'user',
            'posts.image',
            'posts.comments.user',
            'posts.likes'
        ])->findOrFail($id);

        $userId = auth()->id();

        $isOwner = $userId && $userId === $pet->user_id;

        return view('pet_detail', compact('pet', 'isOwner'));
    }

    public function destroy($id)
    {
        $pet = Pet::findOrFail($id);

        if ($pet->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $pet->delete();

        return redirect()->route('pets.list')
            ->with('success', 'Pet deleted successfully');
    }

    public function edit($id)
    {
        $pet = Pet::findOrFail($id);

        if ($pet->user_id !== auth()->id()) {
            return redirect()->route('pets.list')->with('error', 'Unauthorized');
        }

        $types = PetType::all();

        return view('pets_edit', compact('pet', 'types'));
    }

    public function update(Request $request, $id)
    {
        $pet = Pet::findOrFail($id);

        if ($pet->user_id !== auth()->id()) {
            return redirect()->route('pets.list')->with('error', 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|min:2',
            'type_id' => 'required',
            'image' => 'nullable|image',
            'age' => 'required|integer|min:1',
        ]);


        if ($request->hasFile('image')) {

            if ($pet->image) {
                Storage::disk('public')->delete($pet->image->path);
            }

            $path = $request->file('image')->store('pets', 'public');

            $pet->image->update([
                'path' => $path
            ]);
        }

        $pet->update([
            'name' => $request->name,
            'type_id' => $request->type_id,
            'age' => $request->age,
            'description' => $request->description,
        ]);

        return redirect()->route('pets.show', $pet->id)
            ->with('success', 'Pet updated successfully');
    }
}