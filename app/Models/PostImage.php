<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class PostImage extends Model
{
    /** @use HasFactory<\Database\Factories\PostImageFactory> */
    use HasFactory;

    protected $fillable = [
        'post_id',
        'filename',
        'path',
        'is_cover',
        'order',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function url(): string
    {
        return asset('storage/'.$this->path);
    }

    protected function casts(): array
    {
        return [
            'is_cover' => 'boolean',
            'order' => 'integer',
        ];
    }
}
