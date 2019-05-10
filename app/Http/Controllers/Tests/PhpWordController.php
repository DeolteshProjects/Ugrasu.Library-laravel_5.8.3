<?php

namespace App\Http\Controllers\Tests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpWord\PhpWord;

class PhpWordController extends Controller
{
    //
    public function index() {

        // Creating the new document...
        $phpWord = new PhpWord();

        //Загружаем шаблон
        $template = $phpWord->loadTemplate('docs/templates/Template.docx'); //шаблон


        if ($template) echo "Шаблон успешно загружен</br>";
        //Указываем направление подготовки
        $template->setValue('br_special_special', '09.03.01 - Информатика и вычислительная техника'); //номер договора

        /* Note: any element you append to a document must reside inside of a Section. */

        // Adding an empty Section to the document...


// Adding Text element to the Section having font styled by default...
        $records = Session::get('libraryList.records.tBook');
        //print_r($records[0]['SmallDescription']);
        $smd = $records[0]['SmallDescription'];
        //$book = $array[]

        //Сохраняем библиографическую справку
        //$template = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        if ($template->saveAs('docs/reports/Библиографическая справка от '.date('Y-m-d H.i.s').'.docx')) echo "Справка сохранена";

    }
}
