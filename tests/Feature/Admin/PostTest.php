<?php

declare(strict_types=1);

use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->admin = User::factory()->create();
    $this->actingAs($this->admin);
});

it('admin can list posts', function (): void {
    Post::factory(3)->create();

    $this->get(route('admin.posts.index'))->assertOk();
});

it('admin can view create post form', function (): void {
    $this->get(route('admin.posts.create'))->assertOk();
});

it('admin can create a post', function (): void {
    $response = $this->post(route('admin.posts.store'), [
        'title' => 'My New Post',
        'content' => 'Some content here.',
        'status' => PostStatus::Draft->value,
    ]);

    $response->assertRedirect(route('admin.posts.index'));
    $this->assertDatabaseHas('posts', ['title' => 'My New Post']);
});

it('admin can edit a post', function (): void {
    $post = Post::factory()->create();

    $this->get(route('admin.posts.edit', $post))->assertOk();
});

it('admin can update a post', function (): void {
    $post = Post::factory()->create();

    $response = $this->put(route('admin.posts.update', $post), [
        'title' => 'Updated Title',
        'content' => 'Updated content.',
        'status' => PostStatus::Published->value,
    ]);

    $response->assertRedirect(route('admin.posts.index'));
    $this->assertDatabaseHas('posts', ['id' => $post->id, 'title' => 'Updated Title']);
});

it('admin can delete a post', function (): void {
    $post = Post::factory()->create();

    $response = $this->delete(route('admin.posts.destroy', $post));

    $response->assertRedirect(route('admin.posts.index'));
    $this->assertSoftDeleted('posts', ['id' => $post->id]);
});

it('sets published_at when publishing a post', function (): void {
    $post = Post::factory()->create(['status' => PostStatus::Draft, 'published_at' => null]);

    $this->put(route('admin.posts.update', $post), [
        'title' => $post->title,
        'content' => $post->content,
        'status' => PostStatus::Published->value,
    ]);

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'status' => PostStatus::Published->value,
    ]);
    expect($post->fresh()->published_at)->not->toBeNull();
});

it('validates required fields on store', function (): void {
    $this->post(route('admin.posts.store'), [])
        ->assertSessionHasErrors(['title', 'content', 'status']);
});

it('validates required fields on update', function (): void {
    $post = Post::factory()->create();

    $this->put(route('admin.posts.update', $post), [])
        ->assertSessionHasErrors(['title', 'content', 'status']);
});
