<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/hris');
});

use App\Filament\Pages\Settings;

Route::get('/settings', [Settings::class, 'render'])->name('filament.pages.settings');

