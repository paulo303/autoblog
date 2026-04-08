<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\DestroyPostImageController;
use App\Http\Controllers\Admin\GeneratePostFromYoutubeController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\BlogController;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Blog público
Route::get('/', [BlogController::class, 'index'])->name('blog.index');
Route::get('/posts/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Autenticação
Route::get('/login', fn (): Factory|View => view('auth.login'))->name('login')->middleware('guest');
Route::post('/login', function (Request $request) {
    /** @var array<string, string> $credentials */
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (auth()->attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();

        return redirect()->intended(route('admin.posts.index'));
    }

    return back()->withErrors(['email' => 'Credenciais inválidas.'])->onlyInput('email');
})->name('login.post')->middleware('guest');

Route::post('/logout', function (Request $request) {
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return to_route('login');
})->name('logout');

// Área administrativa
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function (): void {
    Route::redirect('/', '/admin/posts');
    Route::get('posts/generate-from-youtube', [GeneratePostFromYoutubeController::class, 'create'])->name('posts.generate-from-youtube.create');
    Route::post('posts/generate-from-youtube', [GeneratePostFromYoutubeController::class, 'store'])->name('posts.generate-from-youtube.store');
    Route::resource('posts', PostController::class);
    Route::delete('images/{image}', DestroyPostImageController::class)->name('images.destroy');
});
