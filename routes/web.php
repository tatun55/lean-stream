<?php

use App\Livewire\Page\Dashboard;
use App\Livewire\Page\Login;
use App\Livewire\Page\Profile;
use App\Livewire\Page\Regist;
use App\Livewire\Page\ForgotPassword;
use App\Livewire\Page\ManageEnquiry;
use App\Livewire\Page\ManageOrganisation;
use App\Livewire\Page\ResetPassword;
use App\Livewire\Page\ManageTansactionRecord;
use Illuminate\Support\Facades\Route;

if (app()->isLocal()) {
    Route::get('debug/{name}', function ($name) {
        return view("debug.{$name}");
    });
}

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('manage.enquiry');
    } else {
        return view('welcome');
    }
})->name('welcome');

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('regist', Regist::class)->name('regist');
    Route::get('forgot-password', ForgotPassword::class)->name('password.forgot');
    Route::get('reset-password/{token}', ResetPassword::class)->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('profile', Profile::class)->name('profile');
    Route::get('transaction-record', ManageTansactionRecord::class)->name('manage.transaction-record');
    Route::get('manage-organisation', ManageOrganisation::class)->name('manage.organisation');
    Route::get('manage-enquiry', ManageEnquiry::class)->name('manage.enquiry');
});
