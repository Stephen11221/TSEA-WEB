<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::view('/workforce-passport', 'pages.workforce-passport')->name('passport');
Route::view('/eri', 'pages.eri')->name('eri');
Route::view('/programs', 'pages.programs')->name('programs');
Route::view('/employers', 'pages.employers')->name('employers');
Route::view('/institutions', 'pages.institutions')->name('institutions');
Route::view('/workforce-intelligence', 'pages.workforce-intelligence')->name('intelligence');
Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/create-passport', 'pages.workforce-passport')->name('passport.create');
