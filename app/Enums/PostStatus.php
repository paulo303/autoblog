<?php

declare(strict_types=1);

namespace App\Enums;

enum PostStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
    case Archived = 'archived';

    public function label(): string
    {
        return match ($this) {
            PostStatus::Draft => 'Rascunho',
            PostStatus::Published => 'Publicado',
            PostStatus::Archived => 'Arquivado',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            PostStatus::Draft => 'bg-yellow-500/20 text-yellow-400 ring-yellow-500/30',
            PostStatus::Published => 'bg-green-500/20 text-green-400 ring-green-500/30',
            PostStatus::Archived => 'bg-zinc-500/20 text-zinc-400 ring-zinc-500/30',
        };
    }

    public function isPublished(): bool
    {
        return $this === PostStatus::Published;
    }
}
