<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // SIMPAN KOMENTAR BARU
    public function store(Request $request)
    {
        $request->validate([
            'video_id' => 'required|string',
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);
        
        $comment = Comment::create([
            'user_id' => Auth::id(),
            'video_id' => $request->video_id,
            'content' => $request->content,
            'parent_id' => $request->parent_id
        ]);
        
        // Load user data untuk response
        $comment->load('user');
        
        return response()->json([
            'success' => true,
            'comment' => $comment,
            'message' => 'Comment added successfully'
        ]);
    }
    
    // AMBIL KOMENTAR BERDASARKAN VIDEO
    public function index(Request $request, $videoId)
    {
        $perPage = $request->get('per_page', 10);
        
        $comments = Comment::with(['user', 'replies.user'])
            ->where('video_id', $videoId)
            ->whereNull('parent_id') // Hanya komentar utama
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        
        return response()->json($comments);
    }
    
    // HAPUS KOMENTAR
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        
        // Cek apakah user pemilik komentar
        if ($comment->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
        
        $comment->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Comment deleted'
        ]);
    }
    
    // UPDATE KOMENTAR
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);
        
        $comment = Comment::findOrFail($id);
        
        if ($comment->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $comment->update(['content' => $request->content]);
        
        return response()->json([
            'success' => true,
            'comment' => $comment
        ]);
    }
}