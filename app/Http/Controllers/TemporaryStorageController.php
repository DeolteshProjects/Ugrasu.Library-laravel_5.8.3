<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class TemporaryStorageController extends Controller
{
    //
    /**
     *
     */
    public function index() {

       $liter = Input::post();

       $number = 0;
       //Проверяем существование временного списка
        if (Session::has('libraryList.number')) {
            $number = Session::get('libraryList.number') + 1;
            Session::put('libraryList.number', $number);
        } else {
            Session::put('libraryList.number', $number);
        }


        $Id = $liter['Id'];
        $Author = $liter['Author'];
        $ViewOfPublication = $liter['ViewOfPublication'];
        $SmallDescription = $liter['SmallDescription'];
        $NumberOfCopies = $liter['NumberOfCopies'];
       //Заносим выбранную книгу в куки
        Session::put('libraryList.records.'.$number.'.Id', $Id);
        Session::put('libraryList.records.'.$number.'.Author', $Author);
        Session::put('libraryList.records.'.$number.'.ViewOfPublication', $ViewOfPublication);
        Session::put('libraryList.records.'.$number.'.SmallDescription', $SmallDescription);
        Session::put('libraryList.records.'.$number.'.NumberOfCopies', $NumberOfCopies);
        Session::save();
        $report = Session::get('libraryList.records');
        print_r($report);
        echo "Сохраненно ".count($report)." записей";

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
