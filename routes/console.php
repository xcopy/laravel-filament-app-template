<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('ide-helper:all', function () {
    $this->call('ide-helper:eloquent');
    $this->call('ide-helper:generate');
    $this->call('ide-helper:models', ['--nowrite' => true]);
});

Artisan::command('app:localize', function () {
    $this->call('translatable:export', ['lang' => config('app.locale')]);
});

Artisan::command('app:optimize', function () {
    $this->call('filament:optimize');
    $this->call('optimize');
});

Artisan::command('app:optimize-clear', function () {
    $this->call('filament:optimize-clear');
    $this->call('optimize:clear');
});
