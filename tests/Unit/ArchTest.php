<?php

declare(strict_types=1);

arch()->preset()->php()->ignoring([
    'App\Models\Post',
    'App\Models\PostImage',
]);
arch()->preset()->strict()->ignoring([
    'App\Models\Post',
    'App\Models\PostImage',
]);
arch()->preset()->laravel()->ignoring([
    'App\Models\Post',
    'App\Models\PostImage',
]);
arch()->preset()->security()->ignoring([
    'assert',
]);

arch('controllers')
    ->expect('App\Http\Controllers')
    ->not->toBeUsed();

//
