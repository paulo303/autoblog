<?php

use App\Jobs\GeneratePostFromYoutubeJob;

test('job has a timeout configured', function () {
    $job = new GeneratePostFromYoutubeJob('https://www.youtube.com/watch?v=dQw4w9WgXcQ');

    expect($job->timeout)->toBe(180);
});
