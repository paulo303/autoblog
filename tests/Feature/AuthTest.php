<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the login page', function (): void {
    $this->get(route('login'))->assertOk();
});

it('admin user can login and is redirected to admin posts', function (): void {
    $user = User::factory()->create([
        'email' => 'admin@autoblog.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->post(route('login.post'), [
        'email' => 'admin@autoblog.com',
        'password' => 'password',
    ]);

    $response->assertRedirect(route('admin.posts.index'));
    $this->assertAuthenticatedAs($user);
});

it('rejects invalid credentials', function (): void {
    User::factory()->create(['email' => 'admin@autoblog.com', 'password' => bcrypt('password')]);

    $response = $this->post(route('login.post'), [
        'email' => 'admin@autoblog.com',
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

it('unauthenticated user is redirected from admin routes', function (): void {
    $this->get(route('admin.posts.index'))->assertRedirect(route('login'));
});

it('authenticated user can logout', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('logout'))
        ->assertRedirect(route('login'));

    $this->assertGuest();
});
