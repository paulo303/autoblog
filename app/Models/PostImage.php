<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\PostImageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class PostImage extends Model
{
    /** @use HasFactory<PostImageFactory> */
    use HasFactory;

    protected $fillable = [
        'post_id',
        'filename',
        'path',
        'is_cover',
        'order',
    ];

    /**
     * @return BelongsTo<Post, $this>
     */
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
