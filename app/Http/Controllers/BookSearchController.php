<?php

namespace App\Http\Controllers;

use App\Models\BookSearch;
use Illuminate\Http\Request;
use App\Library\Irbis;
use App\Library\Parser;
use App\Models\BookSearchFilter;
use Illuminate\Support\Facades\Session;

class BookSearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        //Отображаем запросившему форму поиска книг
        //return view('bookSearch.SearchBookForm');
        return view('bookSearch.index');
    }

    public function libraryReport()
    {
        return view('bookSearch.libraryReport');
    }

    //
    public function result()
    {
        //Создаем экземпляр класса Irbis
        $Irbis = new Irbis();
        //Выполняем попытку подключения к серверу
        if ($Irbis->login()) {
            //Выполняем поисковые запросы
            $result = $Irbis->recordsSearch(($Irbis->getQuery($_POST)), null, 1, "@");
            //Если не получен код ошибки, продолжаем работать
            if ($result['error_code'] == 0) {
                //print_r($result);
                $Parser = new Parser();
                //Сливаем все результаты в единый массив
                $AllAnswer = array_merge_recursive($result['FOND'], $result['ZNANIUM'], $result['URAIT'], $result['LAN']);

                /*
                print_r($AllAnswer);
                exit();
                */

                
                if (isset($result['searchNumber'])) {
                    $Answer = [];
                    for ($i = 0; $i < ($result['searchNumber'] - 1); $i++) {
                        $Answer[$i] = $Parser->getSmallParse($AllAnswer['records'][$i + 1]);
                    }
                    /*
                         *  Фильтры
                         *  filterByOldYearOfPublication - Очистка литературы старше 20 лет
                         *  filterByStock   - Очистка печатной литературы имеющейся в наличии менее 3 штук
                         *  filterByAuthor - Очистка литературы, где автор не соответствует запрошенному или отсутствует
                         *  filterByStopWord - Очистка литературы, где описание содержит стоп слова
                         */
                    //Если ведется создание БС выполняем фильтрацию результатов
                    if (Session::has('LibraryReportDiscLocal.Creating')) {
                        //Фильтруем литературу изданную более 20 лет назад
                        $Answer = ((new BookSearchFilter())->filterByOldYearOfPublication($Answer));
                        //Фильтруем литературу по остаткам в библиотеке
                        if (Session::has('LibraryReportDiscLocal.Creating')) $Answer = ((new BookSearchFilter())->filterByStock($Answer));
                        //Если был введен автор, фильтруем по автору
                        if (!empty($_POST['bookAuthor'])) $Answer = (new BookSearchFilter())->filterByAuthor($_POST['bookAuthor'], $Answer);
                        //Если были введены стоп слова, фильтруем по стоп словам
                        if (!empty($_POST['bookStopWord'])) $Answer = (new BookSearchFilter())->filterByStopWord($_POST['bookStopWord'], $Answer);
                    }

                    return view('bookSearch.result')->with([
                        'searchNumber' => $result['searchNumber'],
                        'searchTime' => $result['searchTime'],
                        'searchResult' => $result,
                        'realSearchNumber' => count($Answer),
                        'answer' => $Answer
                    ]);

                } else {
                    return view('bookSearch.result')->with([
                        'searchTime' => $result['searchTime']
                    ]);
                }
            } else {
                return view('bookSearch.error')->with(['error_code' => $result['error_code'], 'error_text' => $Irbis->error($result['error_code'])]);
            }
        } else {
            return view('errors/OtherError')->with(['error_code' => "6002", 'error_text' => "Ошибка при работе с сервером библиотеки!"]);
        }
    }
}
