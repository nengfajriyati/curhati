<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Reaction;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $posts = Post::with(['category', 'comments', 'reactions'])
                    ->when(
                        $request->category,
                        function ($query) use ($request) {

                            $query->where(
                                'category_id',
                                $request->category
                            );

                        }
                    )
                    ->latest()
                    ->get();

        $userReactionMap = [];

        if (auth()->check()) {
            $userReactions = Reaction::whereIn('post_id', $posts->pluck('id'))
                ->where('user_id', auth()->id())
                ->pluck('type', 'post_id');

            $userReactionMap = $userReactions->toArray();
        }

        return view(
            'feed',
            compact(
                'posts',
                'categories',
                'userReactionMap'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'isi' => 'required',

            'category_id' => 'required',

            'gambar' => 'nullable|image|max:4096'

        ]);

        $gambarPath = null;

        if ($request->hasFile('gambar')) {

            $gambarPath = $request
                            ->file('gambar')
                            ->store('posts', 'public');
        }

        Post::create([

            'user_id' => auth()->id(),

            'category_id' => $request->category_id,

            'isi' => $request->isi,

            'gambar' => $gambarPath

        ]);

        return redirect('/')
                ->with(
                    'success',
                    'Aspirasi berhasil dibagikan secara anonim ✨'
                );
    }
}