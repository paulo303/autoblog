<?php

declare(strict_types=1);

use App\Jobs\GeneratePostFromYoutubeJob;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->admin = User::factory()->create();
    $this->actingAs($this->admin);
});

it('admin can view the generate from youtube form', function (): void {
    $this->get(route('admin.posts.generate-from-youtube.create'))
        ->assertOk()
        ->assertSee('Gerar Post do YouTube');
});

it('dispatches a job when a youtube url is submitted', function (): void {
    Queue::fake();

    $response = $this->post(route('admin.posts.generate-from-youtube.store'), [
        'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
    ]);

    $response->assertRedirect(route('admin.posts.generate-from-youtube.create'));
    $response->assertSessionHas('success');

    Queue::assertPushed(GeneratePostFromYoutubeJob::class, fn ($job): bool => $job->youtubeUrl === 'https://www.youtube.com/watch?v=dQw4w9WgXcQ');
});

it('validates that youtube_url is required', function (): void {
    $this->post(route('admin.posts.generate-from-youtube.store'), [])
        ->assertSessionHasErrors(['youtube_url']);
});

it('validates that youtube_url must be a valid youtube link', function (): void {
    $this->post(route('admin.posts.generate-from-youtube.store'), [
        'youtube_url' => 'https://vimeo.com/123456',
    ])->assertSessionHasErrors(['youtube_url']);
});

it('redirects guests to login', function (): void {
    auth()->logout();

    $this->get(route('admin.posts.generate-from-youtube.create'))
        ->assertRedirect(route('login'));

    $this->post(route('admin.posts.generate-from-youtube.store'), [
        'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
    ])->assertRedirect(route('login'));
});
