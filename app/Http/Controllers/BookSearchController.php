<?php

namespace App\Http\Controllers;

use App\Models\BookSearch;
use Illuminate\Http\Request;
use App\Library\Irbis;
use App\Library\Parser;

//Session start
use Illuminate\Support\Facades\Session;

class BookSearchController extends Controller
{
    public function index()
    {
        //Отображаем запросившему форму поиска книг
        return view('bookSearch.index');
    }

    public function libraryReport()
    {
    //    if (isset($_GET['submit'])) {
            //Отображаем запросившему форму поиска книг
            return view('bookSearch.libraryReport',[
     //           'Special' => $_GET['Special']
            ]);
    //    }
    }

    //
    public function result()
    {
        //Создаем экземпляр класса Irbis
        $Irbis = new Irbis();
        //Выполняем попытку подключения к серверу
        if ($Irbis->login()) {
            //Выполняем попытку собрать поисковый запрос
            $searchQuery = $Irbis->getQuery($_POST);
            //Выполняем поисковые запросы
            $result = $Irbis->recordsSearch($searchQuery, $_POST['bookLimit'], 1, "@");
            if ($result['error_code'] == 0) {
                //print_r($result);
                $Parser = new Parser();
                //Сливаем все результаты в единый массив
                $AllAnswer = array_merge_recursive($result['FOND'],$result['ZNANIUM'],$result['URAIT'],$result['LAN']);


                if (isset($result['searchNumber'])) {

                    if (Session::has("libraryList")) {
                        $hase = Session::get("libraryList.hase");
                        echo "Ok!";
                        print_r($hase);
                    };

                    $Answer = [];
                    if ($result['searchNumber'] > $_POST['bookLimit']) {
                        for ($i = 0; $i<($_POST['bookLimit'] - 1); $i++) {
                            $Answer[$i] = $Parser->getSmallParse($AllAnswer['records'][$i+1]);
                            //Удаляем из результатов издания, имеющиеся в наличии менее 3 шт. или год издания меньше 2000
                            if (((isset($Answer[$i]['NumberOfCopies'])) AND ((((int)($Answer[$i]['NumberOfCopies'])) < 3) AND ($Answer[$i]['NumberOfCopies'] !== "Неограниченно"))) OR ((isset($Answer[$i]['YearOfPublication'])) AND (((int)($Answer[$i]['YearOfPublication'])) < 2000))) unset($Answer[$i]);
                            else if (isset($hase)) {
                                if (in_array($hase, $Answer[$i]['SmallDescription'], $hase)) { echo "lalalalalalal"; }
                                if ($hase[0] !== $Answer[$i]['SmallDescription']) echo "Пиздец";
                                else echo "//////".$Answer[$i]['SmallDescription']."//////";
                            };
                        }
                    } else {
                        for ($i = 0; $i<($result['searchNumber'] - 1); $i++) {
                            $Answer[$i] = $Parser->getSmallParse($AllAnswer['records'][$i+1]);
                            //Удаляем из результатов издания, имеющиеся в наличии менее 3 шт. или год издания меньше 2000
                            if (((isset($Answer[$i]['NumberOfCopies'])) AND ((((int)($Answer[$i]['NumberOfCopies'])) < 3) AND ($Answer[$i]['NumberOfCopies'] !== "Неограниченно"))) OR ((isset($Answer[$i]['YearOfPublication'])) AND (((int)($Answer[$i]['YearOfPublication'])) < 2000))) unset($Answer[$i]);
                            else if (isset($hase)) {
                                if (in_array($Answer[$i]['SmallDescription'], $hase)) { echo "lalalalalalal"; }
                                if ($hase[0] !== $Answer[$i]['SmallDescription']) echo "Пиздец";
                                else echo "//////".$Answer[$i]['SmallDescription']."//////";
                            };
                        }
                    }

                    return view('bookSearch.result')->with([
                        'searchQuery' => $searchQuery,
                        'searchNumber' => $result['searchNumber'],
                        'searchTime' => $result['searchTime'],
                        'searchResult' => $result,
                        'realSearchNumber' => count($Answer),
                        'limit' => $_POST['bookLimit'],
                        'answer' => $Answer
                    ]);

                    //echo count($AllAnswer['records']);
                    //print_r($AllAnswer['records']);
                } else {
                    return view('bookSearch.result')->with([
                        'searchQuery' => $searchQuery,
                        'searchTime' => $result['searchTime']
                    ]);
                }
            } else {
                return view('bookSearch.error')->with(['error_code' => $result['error_code'], 'error_text' => $Irbis->error($result['error_code'])]);
            }
        } else {
            return view('errors/OtherError')->with(['error_code' => "6002", 'error_text' => "Ошибка при авторизации на сервере библиотеки!"]);
        }
    }
}
