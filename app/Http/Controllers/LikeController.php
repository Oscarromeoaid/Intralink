<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Notification;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Post $post)
    {
        // COMMENTE OU SUPPRIME CETTE LIGNE POUR TESTER
        // if (!request()->ajax()) {
        //     return redirect()->route('home');
        // }

        $user = auth()->user();
        $existingLike = $post->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            $existingLike->delete();
            $liked = false;
        } else {
            $post->likes()->create(['user_id' => $user->id]);
            $liked = true;

            // Créer une notification pour le propriétaire du post
            if ($post->user_id !== $user->id) {
                Notification::create([
                    'user_id' => $post->user_id,
                    'from_user_id' => $user->id,
                    'post_id' => $post->id,
                    'type' => 'like',
                    'message' => "{$user->name} a aimé votre publication",
                    'read' => false,
                ]);
            }
        }

        return response()->json([
            'liked' => $liked,
            'count' => $post->likes()->count()
        ]);
    }
}
