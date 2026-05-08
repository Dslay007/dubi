<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = Comment::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('member_id', 'like', "%{$search}%")
                  ->orWhere('comment', 'like', "%{$search}%");
        }
        $comments = $query->orderBy('last_update', 'desc')->paginate(15)->appends($request->all());
        return view('admin.comment.index', compact('comments'));
    }

    public function destroy($id)
    {
        Comment::destroy($id);
        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}
