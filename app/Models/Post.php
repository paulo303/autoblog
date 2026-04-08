<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PostStatus;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

final class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'status',
        'published_at',
    ];

    /**
     * @return HasMany<PostImage, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(PostImage::class)->orderBy('order');
    }

    public function coverImage(): ?PostImage
    {
        /** @var PostImage|null $image */
        $image = $this->images->firstWhere('is_cover', true) ?? $this->images->first();

        return $image;
    }

    protected static function booted(): void
    {
        self::creating(function (Post $post): void {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }

            if (empty($post->excerpt) && $post->content) {
                $post->excerpt = Str::limit(strip_tags($post->content), 160);
            }
        });

        self::updating(function (Post $post): void {
            if ($post->isDirty('title') && ! $post->isDirty('slug')) {
                $post->slug = Str::slug($post->title);
            }

            if ($post->isDirty('content') && ! $post->isDirty('excerpt')) {
                $post->excerpt = Str::limit(strip_tags($post->content), 160);
            }
        });
    }

    /**
     * @param  Builder<Post>  $query
     * @return Builder<Post>
     */
    protected function scopePublished(Builder $query): Builder
    {
        return $query->where('status', PostStatus::Published)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * @param  Builder<Post>  $query
     * @return Builder<Post>
     */
    protected function scopeLatestPublished(Builder $query): Builder
    {
        return $query->latest('published_at');
    }

    protected function casts(): array
    {
        return [
            'status' => PostStatus::class,
            'published_at' => 'datetime',
        ];
    }
}
