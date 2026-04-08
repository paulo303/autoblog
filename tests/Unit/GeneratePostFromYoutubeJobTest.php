<?php

declare(strict_types=1);

use App\Jobs\GeneratePostFromYoutubeJob;

test('job has a timeout configured', function (): void {
    $job = new GeneratePostFromYoutubeJob('https://www.youtube.com/watch?v=dQw4w9WgXcQ');

    expect($job->timeout)->toBe(180);
});

test('job has retry attempts configured', function (): void {
    $job = new GeneratePostFromYoutubeJob('https://www.youtube.com/watch?v=dQw4w9WgXcQ');

    expect($job->tries)->toBe(3);
    expect($job->backoff)->toBe(30);
});
