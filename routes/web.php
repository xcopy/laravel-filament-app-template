<?php

use Illuminate\Support\Facades\Route;

if (app()->environment('local')) {
    Route::mailPreview();
}
