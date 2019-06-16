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

Route::group(['prefix'=>'auth'], function () {
    //Форма авторизации
    Route::get('/', 'Auth\AuthenticateController@getLoginFormAction')->name('getLoginForm');
    //Авторизация
    Route::get('/login/{auth_name}', 'Auth\AuthenticateController@loginAction')->name('login');
    //Выход из системы
    Route::post('/logout', 'Auth\AuthenticateController@logoutAction')->name('logout');
});


Route::group(['midlware' => ['auth']], function () {

    Route::get('/', 'HomeController@index')->name('home');

    //Поиск книг
    Route::group(['prefix' => 'bookSearch','midlware' => ['auth']], function () {
        //Запрос страницы поиска книг
        Route::get('/', 'BookSearchController@index')->name('bookSearch.index');
        //Получение формы составления библиотечной справки
        Route::get('/toLibraryReport', 'BookSearchController@libraryReport')->name('bookSearch.libraryReport');
        //Результаты поиска книг
        Route::post('/result', 'BookSearchController@result')->name('bookSearch.result');
    });
    
    //Библиографические справки
    Route::group(['prefix' => 'libraryReports','midlware' => ['auth']], function () {

        //Уже собранные составленные библиографические справки
        Route::group(['prefix'=>'Library', 'midlware' => ['auth']], function () {
            //Отображение сотавляющих библиографическую справку по направлению обучения
            Route::get('/Composition/{year}/{specialitycode}', 'LibraryReports\LibraryReportDiscLibraryController@compositionSpecialAction')->name('ReportCompositionSpecial');
            //Отображение выбранной библиографической справки по направлению обучения
            Route::post('/PrintSpecial', 'LibraryReports\PrintLibraryReportController@printOnlyOneSpecialAction')->name('PrintReportOnlyOneSpecial');
            //Отображение выбранной библиографической справки по дисциплине
            Route::post('/PrintDisc', 'LibraryReports\PrintLibraryReportController@printOnlyOneDiscAction')->name('PrintReportOnlyOneDisc');
            //Отображение принятых библиографических справок по направлению
            Route::get('/SuccessSpec', 'LibraryReports\LibraryReportDiscLibraryController@getSuccessSpecAction')->name('LibraryReportDiscLibraryCompiled.getSuccessSpec');
            //Отображение всех библиографических справок
            Route::get('/All', 'LibraryReports\LibraryReportDiscLibraryController@getAllAction')->name('LibraryReportDiscLibraryCompiled.getAll');
            //Отображение только новых библиографических справок
            Route::get('/New', 'LibraryReports\LibraryReportDiscLibraryController@getAllNewAction')->name('LibraryReportDiscLibraryCompiled.getAllOnlyNew');
            //Отображение только принятых библиографических справок
            Route::get('/Success', 'LibraryReports\LibraryReportDiscLibraryController@getAllSuccessAction')->name('LibraryReportDiscLibraryCompiled.getAllOnlySuccess');
            //Отображение только отклоненных библиографических справок
            Route::get('/Danger', 'LibraryReports\LibraryReportDiscLibraryController@getAllDangerAction')->name('LibraryReportDiscLibraryCompiled.getAllOnlyDanger');
            //Отображение выбранной библиографической справки
            Route::get('/Show', 'LibraryReports\LibraryReportDiscLibraryController@showLibraryReportAction')->name('LibraryReportDiscLibraryCompiled.showLibraryReport');
            //Изменение статуса библиографической справки
            Route::post('updateStatusLibraryReportDisc', 'LibraryReports\LibraryReportDiscLibraryController@updateStatusInLibraryReportDiscAction')->name('LibraryReportDiscLibraryCompiled.updateStatusInLibraryReportDisc');
        });

        Route::get('/create', 'LibraryReportController@create')->name('libraryReports.create');
    });

    //Обработчики формы получения данных об направлении
    Route::group(
        ['prefix' => 'workprogram', 'midlware' => ['auth']], function () {
        //Роут получения направлений по году
        Route::post('/getSpeciality', 'LibraryReports\WorkProgramController@getSpecialityAction')->name('WorkProgram.getSpeciality');
        //Роут дисциплин по направлению и году
        Route::post('/getDisciplines', 'LibraryReports\WorkProgramController@getDisciplineAction')->name('WorkProgram.getDisciplines');
        //Роут для получения FGOS
        Route::post('/getFGOS', 'LibraryReports\WorkProgramController@getFGOSAction')->name('WorkProgram.getFGOS');
    });

    //Обработка сохранений и обновлений данных для составляемой БС
    Route::group(['prefix'=>'compiler', 'midlware' => ['auth']], function () {
        //Создание локальной БС в сессиию
        Route::get('/create', 'LibraryReports\Compiler\CompilerController@getLibraryReportCreateForm')->name('Compiler.getLibraryReportCreateForm');
        //Сохранениие локальной информации о БС в сессиию
        Route::post('/saveLocal', 'LibraryReports\Compiler\CompilerController@createAction')->name('Compiler.create');
        //Очиска локальной информации о литераруре
        Route::post('/cleanLocal', 'LibraryReports\Compiler\CompilerController@cleanAction')->name('Compiler.clean');
        //Удаление локальной информации о БС в сессиию
        Route::post('/deleteLocal', 'LibraryReports\Compiler\CompilerController@deleteAction')->name('Compiler.delete');
        //Получение локальной информации о БС в сессиию
        Route::get('/getLocal', 'LibraryReports\Compiler\CompilerController@getCreatingLocalLibraryReportAction')->name('Compiler.getCreatingLocalLibraryReport');
        //Добавление литературы локальной информации о БС в сессиию
        Route::post('/addBook', 'LibraryReports\Compiler\CompilerController@addBookAction')->name('Compiler.addBook');
        //Удаление литературы из составляемой библиографической справки
        Route::post('/deleteBook','LibraryReports\Compiler\CompilerController@deleteBookAction')->name('Compiler.deleteBook');
        //Сохранение составленной БС в базу данных
        Route::post('/saveLocalInDB', 'LibraryReports\Compiler\CompilerController@saveAction')->name('Compiler.save');
        //Редактирование составленной БС
        Route::get('/edit/{year}/{specialitycode}/{disciplinecode}', 'LibraryReports\Compiler\CompilerController@editAction')->name('Compiler.edit');
    });


    //Тесты
    Route::group(['prefix' => 'tests'], function () {
        //Тест библиотеки PhpWord
        Route::get('/PhpWord', 'LibraryReports\PrintLibraryReportController@printOnlyOneSpecialAction')->name('TestPhpWord.index');
        //Прочие тесты
        Route::match(['get','post'],'/Test', 'Tests\OtherTestController@index')->name('Test');
        //Тесты соединения с сервером базы данных и сервером библиотеки
        Route::get('/Network', function () {
            return view('config.NetworkStatus');
        })->name('TestNetwork');
        //Тесты соединения с сервером базы данных и сервером библиотеки
        Route::get('/Auth', function () {
            return view('auth.test');
        })->name('TestAuth');
    });

});

