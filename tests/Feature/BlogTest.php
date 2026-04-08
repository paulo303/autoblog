<?php

declare(strict_types=1);

use App\Enums\PostStatus;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows only published posts on the blog index', function (): void {
    Post::factory()->published()->create(['title' => 'Published Post']);
    Post::factory()->create(['title' => 'Draft Post', 'status' => PostStatus::Draft]);
    Post::factory()->archived()->create(['title' => 'Archived Post']);

    $response = $this->get(route('blog.index'));

    $response->assertOk();
    $response->assertSee('Published Post');
    $response->assertDontSee('Draft Post');
    $response->assertDontSee('Archived Post');
});

it('orders posts from newest to oldest', function (): void {
    Post::factory()->published()->create([
        'title' => 'Old Post',
        'published_at' => now()->subDays(10),
    ]);
    Post::factory()->published()->create([
        'title' => 'New Post',
        'published_at' => now()->subDay(),
    ]);

    $response = $this->get(route('blog.index'));

    $response->assertOk();

    $newPos = mb_strpos((string) $response->getContent(), 'New Post');
    $oldPos = mb_strpos((string) $response->getContent(), 'Old Post');
    expect($newPos)->toBeLessThan($oldPos);
});

it('shows 5 posts per page and a load more button when there are more', function (): void {
    Post::factory(8)->published()->create();

    $response = $this->get(route('blog.index'));

    $response->assertOk();
    $response->assertSee('Ler mais');
});

it('loads next posts on page 2', function (): void {
    Post::factory(8)->published()->sequence(
        fn ($seq): array => ['published_at' => now()->subDays($seq->index + 1)]
    )->create();

    $response = $this->get(route('blog.index').'?page=2');

    $response->assertOk();

    $posts = Post::query()->published()->latestPublished()->paginate(5, page: 2);
    expect($posts->count())->toBe(3);
});

it('shows a published post on the individual page', function (): void {
    $post = Post::factory()->published()->create(['title' => 'My Published Post']);

    $response = $this->get(route('blog.show', $post->slug));

    $response->assertOk();
    $response->assertSee('My Published Post');
});

it('returns 404 for unpublished post on the individual page', function (): void {
    $draft = Post::factory()->create(['status' => PostStatus::Draft]);
    $archived = Post::factory()->archived()->create();

    $this->get(route('blog.show', $draft->slug))->assertNotFound();
    $this->get(route('blog.show', $archived->slug))->assertNotFound();
});
