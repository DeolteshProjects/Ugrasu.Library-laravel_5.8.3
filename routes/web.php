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

Route::group(['prefix' => 'auth'], function () {
    //Форма авторизации
    Route::get('/', 'Auth\AuthenticateController@getLoginFormAction')->name('getLoginForm');
    //Авторизация
    Route::get('/login/{auth_name}', 'Auth\AuthenticateController@loginAction')->name('login');
    //Выход из системы
    Route::post('/logout', 'Auth\AuthenticateController@logoutAction')->name('logout');
});

Route::get('/', 'HomeController@index')->name('home');

Route::get('/sql_error', function () {
    return view('errors.SqlError');
})->name('SqlError');

//Поиск книг
Route::group(['prefix' => 'bookSearch', 'midlware' => ['auth']], function () {
    //Запрос страницы поиска книг
    Route::get('/', 'BookSearchController@index')->name('bookSearch.index');
    //Получение формы составления библиотечной справки
    Route::get('/toLibraryReport', 'BookSearchController@libraryReport')->name('bookSearch.libraryReport');
    //Результаты поиска книг
    Route::post('/result', 'BookSearchController@result')->name('bookSearch.result');
});

//Интерфейс сотрудника библиотеки
Route::group(['prefix' => 'Library', 'midlware' => ['auth']], function () {
    //Отображение только новых библиографических справок
    Route::get('/', 'LibraryReports\Library\LibraryController@getAllNewAction')->name('Library.home');
    //Отображение сотавляющих библиографическую справку по направлению обучения
    Route::get('/Composition/{year}/{specialitycode}/{forma}', 'LibraryReports\Library\LibraryController@compositionAction')->name('Library.Composition');
   //Отображение принятых библиографических справок по направлению
    Route::get('/Compiling', 'LibraryReports\Library\LibraryController@getCompilingAction')->name('Library.getSuccessSpec');
    //Отображение всех библиографических справок
    Route::get('/All', 'LibraryReports\Library\LibraryController@getAllAction')->name('Library.getAll');
    //Отображение только новых библиографических справок
    Route::get('/New', 'LibraryReports\Library\LibraryController@getAllNewAction')->name('Library.getAllOnlyNew');
    //Отображение только принятых библиографических справок
    Route::get('/Success', 'LibraryReports\Library\LibraryController@getAllSuccessAction')->name('Library.getAllOnlySuccess');
    //Отображение только отклоненных библиографических справок
    Route::get('/Danger', 'LibraryReports\Library\LibraryController@getAllDangerAction')->name('Library.getAllOnlyDanger');
    //Отображение выбранной библиографической справки
    Route::get('/Show', 'LibraryReports\Library\LibraryController@showAction')->name('Library.show');
    //Изменение статуса библиографической справки
    Route::post('updateStatus', 'LibraryReports\Library\LibraryController@updateStatusAction')->name('Library.updateStatus');
});

Route::group(['prefix' => 'Print'], function () {
    //Печать выбранной библиографической справки по направлению обучения
    Route::post('/PrintSpecial', 'LibraryReports\PrintToWord\PrintToWordController@printSpecialAction')->name('PrintSpecial');
    //Печать выбранной библиографической справки по дисциплине
    Route::post('/PrintDisc', 'LibraryReports\PrintToWord\PrintToWordController@printDiscAction')->name('PrintDisc');
});


//Обработчики формы получения данных об направлении
Route::group(
    ['prefix' => 'WorkProgram'], function () {
    //Роут получения направлений по году
    Route::post('/getSpeciality', 'LibraryReports\WorkProgramController@getSpecialityAction')->name('WorkProgram.getSpeciality');
    //Роут получения формы обучения по году набора и направлению обучения
    Route::post('/getForms', 'LibraryReports\WorkProgramController@getFormAction')->name('WorkProgram.getForms');
    //Роут дисциплин по направлению и году
    Route::post('/getDisciplines', 'LibraryReports\WorkProgramController@getDisciplineAction')->name('WorkProgram.getDisciplines');
    //Роут получения семестров дисциплин по направлению, году и форме обучения
    Route::post('/getSemesters', 'LibraryReports\WorkProgramController@getSemesterAction')->name('WorkProgram.getSemester');
    //Роут для получения FGOS
    Route::post('/getFGOS', 'LibraryReports\WorkProgramController@getFGOSAction')->name('WorkProgram.getFGOS');
});

//Интерфес составителя
Route::group(['prefix' => 'compiler', 'midlware' => ['auth']], function () {
    //Сохранениие локальной информации о БС в сессиию
    Route::get('/', 'LibraryReports\Compiler\CompilerController@homeAction')->name('Compiler.home');
    //Сохранениие локальной информации о БС в сессиию
    Route::post('/create', 'LibraryReports\Compiler\CompilerController@createAction')->name('Compiler.create');
    //Очиска локальной информации о литераруре
    Route::post('/clean', 'LibraryReports\Compiler\CompilerController@cleanAction')->name('Compiler.clean');
    //Удаление локальной информации о БС в сессиию
    Route::post('/delete', 'LibraryReports\Compiler\CompilerController@deleteAction')->name('Compiler.delete');
    //Получение локальной информации о БС в сессиию
    Route::get('/get', 'LibraryReports\Compiler\CompilerController@getAction')->name('Compiler.get');
    //Добавление литературы локальной информации о БС в сессиию
    Route::post('/addBook', 'LibraryReports\Compiler\CompilerController@addBookAction')->name('Compiler.addBook');
    //Удаление литературы из составляемой библиографической справки
    Route::post('/deleteBook', 'LibraryReports\Compiler\CompilerController@deleteBookAction')->name('Compiler.deleteBook');
    //Сохранение составленной БС в базу данных
    Route::post('/save', 'LibraryReports\Compiler\CompilerController@saveAction')->name('Compiler.save');
    //Отображение БС из базы на экран
    Route::get('/show', 'LibraryReports\Compiler\CompilerController@showAction')->name('Compiler.show');
    //Редактирование составленной БС
    Route::get('/edit/{year}/{specialitycode}/{disciplinecode}/{forma}', 'LibraryReports\Compiler\CompilerController@editAction')->name('Compiler.edit');
});


//Тесты
Route::group(['prefix' => 'tests'], function () {
    //Тест библиотеки PhpWord
    Route::get('/PhpWord', 'LibraryReports\PrintLibraryReportController@printOnlyOneSpecialAction')->name('TestPhpWord.index');
    //Прочие тесты
    Route::match(['get', 'post'], '/Test', 'Tests\OtherTestController@index')->name('Test');
    //Тесты соединения с сервером базы данных и сервером библиотеки
    Route::get('/Network', function () {
        return view('config.NetworkStatus');
    })->name('TestNetwork');
    //Тесты соединения с сервером базы данных и сервером библиотеки
    Route::get('/Auth', function () {
        return view('auth.test');
    })->name('TestAuth');
});


