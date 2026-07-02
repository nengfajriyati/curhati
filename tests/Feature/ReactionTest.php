<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Reaction;
use App\Models\User;

it('can create, update, and remove a reaction for a post', function () {
    $user = User::create([
        'nim' => '1234567890',
        'nama' => 'Test User',
        'password' => 'password123',
        'role' => 'mahasiswa',
    ]);

    $category = Category::create([
        'nama' => 'Test Category',
    ]);

    $post = Post::create([
        'user_id' => $user->id,
        'category_id' => $category->id,
        'isi' => 'Test content',
    ]);

    $this->actingAs($user);

    $this->post(route('reaction.toggle', $post), ['type' => 'love'])
        ->assertRedirect();

    $this->assertDatabaseHas('reactions', [
        'post_id' => $post->id,
        'user_id' => $user->id,
        'type' => 'love',
    ]);

    $this->post(route('reaction.toggle', $post), ['type' => 'love'])
        ->assertRedirect();

    $this->assertDatabaseMissing('reactions', [
        'post_id' => $post->id,
        'user_id' => $user->id,
    ]);

    $this->post(route('reaction.toggle', $post), ['type' => 'like'])
        ->assertRedirect();

    $this->assertDatabaseHas('reactions', [
        'post_id' => $post->id,
        'user_id' => $user->id,
        'type' => 'like',
    ]);

    $this->post(route('reaction.toggle', $post), ['type' => 'dislike'])
        ->assertRedirect();

    $this->assertDatabaseHas('reactions', [
        'post_id' => $post->id,
        'user_id' => $user->id,
        'type' => 'dislike',
    ]);
});
