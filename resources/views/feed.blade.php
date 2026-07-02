@extends('layouts.app')

@section('content')

@if(isset($categories))

<div class="category-tabs">

    <a href="/"
       class="category-tab {{ request('category') == null ? 'active' : '' }}">
        Semua
    </a>

    @foreach($categories as $category)

        <a href="/?category={{ $category->id }}"
           class="category-tab {{ request('category') == $category->id ? 'active' : '' }}">
            {{ $category->nama }}
        </a>

    @endforeach

</div>

@endif

@forelse($posts as $post)

@php
    $colors = [
        'avatar-blue',
        'avatar-green',
        'avatar-purple',
        'avatar-pink',
        'avatar-orange'
    ];

    $color = $colors[$post->id % count($colors)];

    $loveCount = $post->reactions->where('type', 'love')->count();
    $likeCount = $post->reactions->where('type', 'like')->count();
    $dislikeCount = $post->reactions->where('type', 'dislike')->count();
    $commentCount = $post->comments->count();

    $userReaction = $userReactionMap[$post->id] ?? null;
@endphp

<div class="card post-card mb-4">

    <div class="card-body">

        <div class="post-header">

            <div class="user-box">

                <div class="avatar-anon {{ $color }}">
                    <i class="bi bi-person-fill"></i>
                </div>

                <div>
                    <div class="anonymous-name">
                        Anonymous
                    </div>

                    <div class="post-category">
                        {{ $post->category->nama ?? 'Umum' }}
                    </div>
                </div>

            </div>

            <div class="text-end">

                <div class="post-time">
                    {{ $post->created_at->diffForHumans() }}
                </div>

                <i class="bi bi-three-dots-vertical text-secondary"></i>

            </div>

        </div>

        <div class="post-content">
            {{ $post->isi }}
        </div>

        @if($post->gambar)

            <div class="post-image mt-3">
                <img
                    src="{{ asset('storage/'.$post->gambar) }}"
                    alt="Gambar aspirasi"
                    loading="lazy">
            </div>

        @endif

        <div class="post-divider"></div>

        <div class="post-actions">

            @guest

                <div class="post-action" onclick="loginRequired()">
                    <i class="bi bi-heart-fill text-danger"></i>
                    <span>{{ $loveCount }}</span>
                </div>

                <div class="post-action" onclick="loginRequired()">
                    <i class="bi bi-hand-thumbs-up-fill text-warning"></i>
                    <span>{{ $likeCount }}</span>
                </div>

                <div class="post-action" onclick="loginRequired()">
                    <i class="bi bi-hand-thumbs-down-fill text-warning"></i>
                    <span>{{ $dislikeCount }}</span>
                </div>

                <div class="post-action" onclick="loginRequired()">
                    <i class="bi bi-chat-fill text-primary"></i>
                    <span>{{ $commentCount }}</span>
                </div>

            @endguest

            @auth

                <form method="POST"
                      action="{{ route('reaction.toggle', $post) }}"
                      class="post-action-form">
                    @csrf

                    <input type="hidden" name="type" value="love">

                    <button type="submit"
                            class="post-action {{ $userReaction === 'love' ? 'active love' : '' }}">
                        <i class="bi bi-heart-fill"></i>
                        <span>{{ $loveCount }}</span>
                    </button>
                </form>

                <form method="POST"
                      action="{{ route('reaction.toggle', $post) }}"
                      class="post-action-form">
                    @csrf

                    <input type="hidden" name="type" value="like">

                    <button type="submit"
                            class="post-action {{ $userReaction === 'like' ? 'active like' : '' }}">
                        <i class="bi bi-hand-thumbs-up-fill"></i>
                        <span>{{ $likeCount }}</span>
                    </button>
                </form>

                <form method="POST"
                      action="{{ route('reaction.toggle', $post) }}"
                      class="post-action-form">
                    @csrf

                    <input type="hidden" name="type" value="dislike">

                    <button type="submit"
                            class="post-action {{ $userReaction === 'dislike' ? 'active dislike' : '' }}">
                        <i class="bi bi-hand-thumbs-down-fill"></i>
                        <span>{{ $dislikeCount }}</span>
                    </button>
                </form>

                <button type="button"
                    class="post-action text-decoration-none"
                    data-bs-toggle="collapse"
                    data-bs-target="#comments-{{ $post->id }}"
                    aria-expanded="false"
                    aria-controls="comments-{{ $post->id }}"
                    onclick="event.preventDefault(); event.stopPropagation();">
                    <i class="bi bi-chat-fill text-primary"></i>
                    <span>{{ $commentCount }}</span>
                </button>

            @endauth

        </div>

        @auth

        <div class="collapse comments-collapse mt-3"
             id="comments-{{ $post->id }}">

            <div class="comment-list">

                @forelse($post->comments->sortByDesc('created_at')->take(3) as $comment)

                    <div class="comment-item d-flex align-items-start mb-3">

                        <div class="comment-avatar me-2">
                            <i class="bi bi-person-fill"></i>
                        </div>

                        <div class="comment-bubble flex-grow-1">

                            <div class="d-flex justify-content-between align-items-start">

                                <div>
                                    <div class="comment-name">
                                        Anonymous
                                    </div>

                                    <div class="comment-time text-muted small">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </div>
                                </div>

                                @if(auth()->id() === $comment->user_id)

                                    <form method="POST"
                                          action="{{ route('comment.destroy', $comment) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-link text-danger p-0">
                                            Hapus
                                        </button>
                                    </form>

                                @endif

                            </div>

                            <div class="comment-text mt-1">
                                {{ $comment->isi }}
                            </div>

                        </div>

                    </div>

                @empty

                    <div class="text-muted small mb-3">
                        Belum ada komentar. Jadi yang pertama nanggepin 👀
                    </div>

                @endforelse

            </div>

            <form method="POST"
                  action="{{ route('comment.store', $post) }}"
                  class="mt-3 d-flex gap-2 comment-form">
                @csrf

                <input type="text"
                       name="isi"
                       class="form-control comment-input"
                       placeholder="Tulis komentar anonim..."
                       required>

                <button type="submit"
                        class="btn btn-primary btn-sm">
                    Kirim
                </button>
            </form>

        </div>

        @endauth

    </div>

</div>

@empty

<div class="card post-card">

    <div class="card-body text-center py-5">

        <h5 class="fw-bold">
            Belum ada curhatan
        </h5>

        <p class="text-muted mb-0">
            Jadi yang pertama buat cerita 👀
        </p>

    </div>

</div>

@endforelse

@endsection
