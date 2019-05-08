<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Models\TemporaryStorage;

class TemporaryStorageController extends Controller
{
    //
    /**
     *
     */
    public function index()
    {
        //Получаем все данные направленные черезх форму
        $liter = Input::post();

        /*Примерный набрососок массива
         *
         * 1.Год набора
         * 2.Направление
         * 3.Дисциплина
         * 4.Фгос
         * 5.База библиотеки книги
         * 6.Айди книги в библиотеке
         * 7.Автор
         * 8.Название
         * 9.Вид издания
         * 10.Описание
         * 11.Необходимое количество
         *
         */


        $book = ['Id' => $liter['Id'], 'Author' => $liter['Author'], 'SmallDescription' => $liter['SmallDescription'], 'NumberOfCopies' => $liter['NumberOfCopies'], 'Book' => $liter['Author'] . ". " . $liter['SmallDescription']];
        //$new_records = $new_records.$book;
        //Проверяем существование временного списка
        if (Session::has('libraryList.number')) {
            $num = Session::get('libraryList.number') + 1;
            Session::put('libraryList.number', $num);
            //$report = Session::get('libraryList.records');
        } else {
            //Если не существует, создаем ее
            Session::put('libraryList.number', 0);
            $num = 0;
        }
        Session::put('libraryList.hase.'.$num,  "]]]]".$liter['SmallDescription']."[[[[");

        //echo count($new_records[2017]["09.03.01 - Информатика и вычислительная техника"]["Fgos3+"]["Математический анализ"][$liter['ViewOfPublication']])."</br>";
        //print_r($book);

        if (Session::has('libraryList.Disc')) {

        }
        else {
            $disc = ['Year' => 2017, 'Special' => "09.03.01 - Информатика и вычислительная", 'Fgos' => "Fgos3+", 'Disc' => "Математический анализ"];
            Session::put('libraryList.Disc', $disc);
        }


        echo $liter['ViewOfPublication'];
        echo "</br>";

        //Заносим выбранную книгу в куки
        if ($liter['ViewOfPublication'] == "[Текст]") {
            if (Session::has('libraryList.records.tBook_number')) {
                $number = Session::get('libraryList.records.tBook_number');
                $col = $number+ 1;
                Session::put('libraryList.records.tBook.'. $number, $book);
                Session::put('libraryList.records.tBook_number', $col);
            } else {
                $number = 0;
                $col = 1;
                Session::put('libraryList.records.tBook_number', $col);
                Session::put('libraryList.records.tBook.'. $number, $book);
            }
        } else if ($liter['ViewOfPublication'] == "[Электронный ресурс]") {
            if (Session::has('libraryList.records.eBook_number')) {
                $number = Session::get('libraryList.records.eBook_number');
                $col = $number+ 1;
                Session::put('libraryList.records.eBook.'. $number, $book);
                Session::put('libraryList.records.eBook_number', $col);
            } else {
                $number = 0;
                $col = 1;
                Session::put('libraryList.records.eBook_number', $col);
                Session::put('libraryList.records.eBook.'. $number, $book);
            }
            echo "Электронный ресурс";
        };
        //Записываем литературу как уже имеющаюся
        Session::save();

        //$report = Session::get('libraryList.records');

        /*
        $_COOKIE['libraryList']['records']['number'] = [
            'Id' => $liter['Id'],
            'Author' => $liter['Author'],
            'ViewOfPublication' => $liter['ViewOfPublication'],
            'SmallDescription' => $liter['SmallDescription'],
            'NumberOfCopies' => $liter['NumberOfCopies'],
        ];
        */
    }
}
