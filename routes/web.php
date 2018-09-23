<?php

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::resource('user', 'UserController');
    Route::resource('branch', 'BranchController');
    Route::resource('member', 'MemberController');
    Route::resource('ledger', 'LedgerController');
});
