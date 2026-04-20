<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalPosts' => Post::count(),
            'totalComments' => Comment::count(),
            'reportedComments' => Comment::where('reported', true)->count(),
            'userPostsCount' => $user->posts()->count(),
            'userLikesReceived' => $user->posts()->withCount('likes')->get()->sum('likes_count'),
            'userCommentsReceived' => $user->posts()->withCount('comments')->get()->sum('comments_count'),
        ]);
    }
    
    public function users()
    {
        $users = User::withCount(['posts', 'comments'])->latest()->paginate(20);
        return view('admin.users', compact('users'));
    }
    
    public function editUser(User $user)
    {
        return view('admin.users-edit', compact('user'));
    }
    
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,moderator,admin',
            'job_title' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
        ]);
        
        $user->update($request->all());
        
        return redirect()->route('admin.users')->with('success', 'Utilisateur mis à jour avec succès');
    }
    
    public function deleteUser(User $user)
    {
        // Supprimer les posts, commentaires et likes de l'utilisateur
        $user->posts()->delete();
        $user->comments()->delete();
        $user->likes()->delete();
        $user->delete();
        
        return redirect()->route('admin.users')->with('success', 'Utilisateur supprimé avec succès');
    }
    
    public function posts()
    {
        $posts = Post::with('user')->withCount(['likes', 'comments'])->latest()->paginate(20);
        return view('admin.posts', compact('posts'));
    }
    
    public function deletePost(Post $post)
    {
        // Supprimer les commentaires et likes du post
        $post->comments()->delete();
        $post->likes()->delete();
        $post->delete();
        
        return redirect()->route('admin.posts')->with('success', 'Post supprimé avec succès');
    }
    
    public function reports()
    {
        $reportedComments = Comment::where('reported', true)->with('user', 'post')->latest()->paginate(20);
        return view('admin.reports', compact('reportedComments'));
    }
    
    public function deleteReportedComment(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('admin.reports')->with('success', 'Commentaire signalé supprimé');
    }
}