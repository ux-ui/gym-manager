<?php

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('setting', 'SettingController@edit')->name('setting');
    Route::post('setting', 'SettingController@update')->name('setting');
    Route::resource('user', 'UserController');
    Route::resource('branch', 'BranchController');
    Route::resource('member', 'MemberController');
    Route::resource('ledger', 'LedgerController');

    Route::get('attendance', 'AttendanceController@index')->name('attendance.index');
    Route::post('attendance', 'AttendanceController@store')->name('attendance.store');
});
