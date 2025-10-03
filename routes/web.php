<?php

use Illuminate\Support\Facades\Route;
use Idoneo\HumanoMailbox\Http\Controllers\MailboxController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/mailbox', [MailboxController::class, 'index'])->name('mailbox.index');
});


