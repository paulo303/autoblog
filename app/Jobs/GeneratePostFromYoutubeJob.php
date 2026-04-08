<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Actions\GeneratePostFromYoutube;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Throwable;

final class GeneratePostFromYoutubeJob implements ShouldQueue
{
    use Queueable;

    public int $timeout = 180;

    public function __construct(public readonly string $youtubeUrl) {}

    public function handle(GeneratePostFromYoutube $action): void
    {
        $action->handle($this->youtubeUrl);
    }

    public function failed(Throwable $exception): void
    {
        Log::error('Falha ao gerar post do YouTube', [
            'youtube_url' => $this->youtubeUrl,
            'error' => $exception->getMessage(),
        ]);
    }
}
