<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        return view('moderator.dashboard', [
            'reportedComments' => Comment::where('reported', true)->count(),
            'totalComments' => Comment::count(),
            'totalPosts' => Post::count(),
            'userPostsCount' => $user->posts()->count(),
            'userCommentsCount' => $user->comments()->count(),
            'userLikesReceived' => $user->posts()->withCount('likes')->get()->sum('likes_count'),
            'recentReportedComments' => Comment::where('reported', true)->with('user', 'post')->latest()->take(5)->get(),
        ]);
    }
    
    public function reportedComments()
    {
        $comments = Comment::where('reported', true)->with('user', 'post')->latest()->paginate(20);
        return view('moderator.reported-comments', compact('comments'));
    }
    
    public function deleteComment(Comment $comment)
    {
        $comment->delete();
        return redirect()->back()->with('success', 'Commentaire supprimé avec succès');
    }
    
    public function ignoreReport(Comment $comment)
    {
        $comment->update(['reported' => false]);
        return redirect()->back()->with('success', 'Signalement ignoré, commentaire conservé');
    }
    
    public function reports()
    {
        $reports = [
            'total_posts' => Post::count(),
            'total_comments' => Comment::count(),
            'reported_comments' => Comment::where('reported', true)->count(),
            'resolved_reports' => Comment::where('reported', false)->whereNotNull('reported_at')->count(),
        ];
        
        return view('moderator.reports', compact('reports'));
    }
}