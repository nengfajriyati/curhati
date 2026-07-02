<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ReactionController extends Controller
{
    public function toggle(Post $post, Request $request): RedirectResponse
    {
        if (! auth()->check()) {
            return Redirect::route('login');
        }

        $request->validate([
            'type' => ['required', 'in:love,like,dislike'],
        ]);

        $user = auth()->user();
        $existingReaction = Reaction::where('post_id', $post->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingReaction) {
            if ($existingReaction->type === $request->type) {
                $existingReaction->delete();

                return Redirect::back()->with('success', 'Reaksi dihapus');
            }

            $existingReaction->update([
                'type' => $request->type,
            ]);

            return Redirect::back()->with('success', 'Reaksi diperbarui');
        }

        Reaction::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'type' => $request->type,
        ]);

        return Redirect::back()->with('success', 'Reaksi tersimpan');
    }
}
