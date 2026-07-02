<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;

it('can create and delete a comment on a post', function () {
    $user = User::create([
        'nim' => '99887766',
        'nama' => 'Commenter',
        'password' => 'password123',
        'role' => 'mahasiswa',
    ]);

    $category = Category::create(['nama' => 'General']);

    $post = Post::create([
        'user_id' => $user->id,
        'category_id' => $category->id,
        'isi' => 'Hello world',
    ]);

    $this->actingAs($user);

    $this->post(route('comment.store', $post), ['isi' => 'Nice post'])
        ->assertRedirect();

    $this->assertDatabaseHas('comments', [
        'post_id' => $post->id,
        'user_id' => $user->id,
        'isi' => 'Nice post',
    ]);

    $comment = Comment::where('post_id', $post->id)->first();

    $this->delete(route('comment.destroy', $comment))
        ->assertRedirect();

    $this->assertDatabaseMissing('comments', [
        'id' => $comment->id,
    ]);
});
