<?php

declare(strict_types=1);

use App\Models\Post;
use App\Models\PostImage;

arch()->preset()->php()->ignoring([
    Post::class,
    PostImage::class,
]);
arch()->preset()->strict()->ignoring([
    Post::class,
    PostImage::class,
]);
arch()->preset()->laravel()->ignoring([
    Post::class,
    PostImage::class,
]);
arch()->preset()->security()->ignoring([
    'assert',
]);

arch('controllers')
    ->expect('App\Http\Controllers')
    ->not->toBeUsed();

//
