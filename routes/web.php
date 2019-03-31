<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['midlware'=>['auth']], function () {

    Route::get('/home', 'HomeController@index')->name('home');

    //Поиск книг
    Route::group(['prefix' => 'bookSearch'], function () {

        //Запрос страницы поиска книг
        Route::get('/', 'BookSearchController@index')->name('bookSearch.index');
        //Получение формы составления библиотечной справки
        Route::get('/toLibraryReport', 'BookSearchController@libraryReport')->name('bookSearch.libraryReport');

        Route::post('/result', 'BookSearchController@result')->name('bookSearch.result');
    });

    //Временное хранение списка книг
    Route::post('/storageListBook', 'TemporaryStorageController@index')->name('temporaryStorageBookList');

    //Поиск книг
    Route::group(['prefix' => 'libraryReports'], function () {

        Route::get('/', 'LibraryReportController@index')->name('libraryReports.index');

    });

   });

