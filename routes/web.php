<?php

use Illuminate\Support\Facades\Route;

if (app()->isLocal()) {
    Route::mailPreview();
}
