<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CommentController extends Controller
{
    public function store(Post $post, Request $request)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'isi' => ['required', 'string', 'max:1000'],
        ]);

        Comment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'isi' => $request->isi,
        ]);

        return Redirect::back()->with('success', 'Komentar dikirim');
    }

    public function destroy(Comment $comment)
    {
        if (! auth()->check() || auth()->id() !== $comment->user_id) {
            abort(403);
        }

        $comment->delete();

        return Redirect::back()->with('success', 'Komentar dihapus');
    }
}
