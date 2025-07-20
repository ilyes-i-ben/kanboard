<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('export:offline', function () {
    $html = view('layouts.app', [
        'header' => '<div>Offline header !</div>',
        'slot' => '<div>Offline slot !</div>',
    ])->render();
    file_put_contents(public_path('index.html'), $html);
    $this->info('static html exported to public/index.html');
});
