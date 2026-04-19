<?php

namespace App\Http\Controllers;

use App\Models\PetPost;
use App\Models\PetPostLike;
use Illuminate\Support\Facades\Auth;

class PostLikeController extends Controller
{
    public function toggle($id)
    {
        $post = PetPost::findOrFail($id);

        $like = PetPostLike::where('post_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            PetPostLike::create([
                'post_id' => $id,
                'user_id' => Auth::id()
            ]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'count' => $post->likes()->count()
        ]);
    }
}
