<?php

declare(strict_types=1);

namespace App\Actions;

use App\Ai\Agents\YoutubePostAgent;
use App\Enums\PostStatus;
use App\Models\Post;
use Illuminate\Support\Str;

final class GeneratePostFromYoutube
{
    public function handle(string $youtubeUrl): Post
    {
        $videoId = $this->extractVideoId($youtubeUrl);

        $prompt = <<<PROMPT
        Crie um post de blog completo a partir deste vídeo do YouTube: {$youtubeUrl}

        ID do vídeo: {$videoId}

        Use suas ferramentas para:
        1. Buscar informações sobre o vídeo no YouTube
        2. Tentar obter a transcrição em: https://youtubetranscript.com/?v={$videoId}
        3. Gerar o post completo em português brasileiro
        PROMPT;

        $response = (new YoutubePostAgent)->prompt($prompt);

        return Post::query()->create([
            /** @phpstan-ignore offsetAccess.nonOffsetAccessible, cast.string */
            'title' => (string) $response['title'],
            /** @phpstan-ignore offsetAccess.nonOffsetAccessible, cast.string */
            'slug' => Str::slug((string) $response['title']),
            /** @phpstan-ignore offsetAccess.nonOffsetAccessible, cast.string */
            'excerpt' => (string) $response['excerpt'],
            /** @phpstan-ignore offsetAccess.nonOffsetAccessible, cast.string */
            'content' => (string) $response['content'],
            'status' => PostStatus::Draft,
        ]);
    }

    private function extractVideoId(string $url): string
    {
        $patterns = [
            '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]{11})/',
            '/youtu\.be\/([a-zA-Z0-9_-]{11})/',
            '/youtube\.com\/shorts\/([a-zA-Z0-9_-]{11})/',
            '/youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return '';
    }
}
