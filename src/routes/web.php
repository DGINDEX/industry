<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 管理者ログイン
Route::prefix('admin')->namespace('Admin')->group(function () {

    Route::get('login/',                     ['as' => 'adminLogin', 'uses' => 'LoginController@index']);
    Route::post('login/',                    'LoginController@login');
    Route::get('logout/',                    'LoginController@logout');
    Route::get('login/reminder/',            'LoginController@reminder');
    Route::post('login/send-mail/',          'LoginController@reminderSendMail');
    Route::get('login/pw-reset/',            ['as' => 'reset', 'uses' => 'LoginController@pwReset']);
    Route::post('login/pw-update/',          'LoginController@pwUpdate');
    Route::get('login/pw-complete/',         'LoginController@pwComplete');
});

// 管理者ページ
Route::prefix('admin')->namespace('Admin')->middleware('auth:administrators')->group(function () {

    //企業管理
    Route::get('company/',                      'CompanyController@index');
    Route::get('company/edit/',                 'CompanyController@edit');
    Route::get('company/edit/{id}/',            'CompanyController@edit');
    Route::post('company/update/',              'CompanyController@update');
    Route::post('company/delete/{id}/',         'CompanyController@delete');
    Route::post('company/image-delete/{id}',   'CompanyController@imageDelete');

    // 案件管理
    Route::get('matching/',                     'MatchingController@index');
    Route::get('matching/edit/',                'MatchingController@edit');
    Route::get('matching/edit/{id}/',           'MatchingController@edit');
    Route::post('matching/update/',             'MatchingController@update');
    Route::post('matching/delete/{id}/',         'MatchingController@delete');
    Route::post('matching/image-delete/{id}',   'MatchingController@imageDelete');

    //ユーザー管理
    Route::get('user/',              'UserController@index');
    Route::get('user/edit/',         'UserController@edit');
    Route::get('user/edit/{id}/',    'UserController@edit');
    Route::post('user/update/',      'UserController@update');
    Route::post('user/delete/{id}/', 'UserController@delete');

    //企業情報CSV取込(直接遷移)
    Route::get('csv-import/',                       'CsvImportController@index');  
    Route::post('csv-import/import/',               'CsvImportController@import');
});


// 企業ログイン
Route::prefix('member')->namespace('Member')->group(function () {

    Route::get('login/',                     ['as' => 'memberLogin', 'uses' => 'LoginController@index']);
    Route::post('login/',                    'LoginController@login');
    Route::get('logout/',                    'LoginController@logout');
    Route::get('login/reminder/',            'LoginController@reminder');
    Route::post('login/send-mail/',          'LoginController@reminderSendMail');
    Route::get('login/pw-reset/',            ['as' => 'member_reset', 'uses' => 'LoginController@pwReset']);
    Route::post('login/pw-update/',          'LoginController@pwUpdate');
    Route::get('login/pw-complete/',         'LoginController@pwComplete');
});

// 企業ページ
Route::prefix('member')->namespace('Member')->middleware('auth:members')->group(function () {

    //企業管理
    Route::get('/',                             'CompanyController@index');
    Route::post('update/',                      'CompanyController@update');
    Route::post('image-delete/{id}/',           'CompanyController@imageDelete');

    // 案件管理
    Route::get('matching/',                     'MatchingController@index');
    Route::get('matching/edit/',                'MatchingController@edit');
    Route::get('matching/edit/{id}/',           'MatchingController@edit');
    Route::post('matching/update/',             'MatchingController@update');
    Route::post('matching/delete/{id}/',        'MatchingController@delete');
    Route::post('matching/image-delete/{id}/',  'MatchingController@imageDelete');
});

//トップ画面
Route::get('/',                              'TopController@index');

//企業画面
Route::get('company/',                          'CompanyController@index');
Route::get('company/detail/',                   'CompanyController@detail');
Route::get('company/detail/{id}/',              'CompanyController@detail');

//案件画面
Route::get('matching/',                         'MatchingController@index');
Route::get('matching/detail/',                  'MatchingController@detail');
Route::get('matching/detail/{id}/',             'MatchingController@detail');
