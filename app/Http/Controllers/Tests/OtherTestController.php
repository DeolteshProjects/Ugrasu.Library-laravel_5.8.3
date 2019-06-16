<?php

namespace App\Http\Controllers\Tests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class OtherTestController extends Controller
{
    /*
     * Тест записи справки в базу данных
     * LibraryReportSaveInDB()
     */
    public function index() {
        //Получаем создаваемую справку из сессии
        $LibraryReport = Session::get('LibraryReportDiscLocal.Creating');
        //Получаем выбранную литературу и преобразуем ее в JSON формат
        $Literature = (json_encode(Session::get('LibraryReportDiscLocal.Literature')));
        //Формируем запрос на запись справки в БД
        $QUERY = "INSERT INTO MY_LR_DISC (
                                      YEARED, YEAREDS, 
                                      SPECIALITYCODE, SPECIALITY, 
                                      DISCIPLINECODE, DISCIPLINE, 
                                      FGOS, COMPILER, CREATEDATE, 
                                      LITERATURE, STATUS, UPDATEDATE, 
                                      ADDEDINFINALLIBRARYREPORT) 
                                    VALUES (:YEARED, :YEAREDS, 
                                      :SPECIALITYCODE, :SPECIALITY, 
                                      :DISCIPLINECODE, :DISCIPLINE, 
                                      :FGOS, :COMPILER, :CREATEDATE, 
                                      :LITERATURE, :STATUS, :UPDATEDATE, 
                                      :ADDEDINFINALLIBRARYREPORT)";
        //Формируем массив атрибутов
        $VALUES = [
            'YEARED'=>$LibraryReport['Yeared'],
            'YEAREDS'=>$LibraryReport['Yeareds'],
            'SPECIALITYCODE'=>$LibraryReport['SpecialityCode'],
            'SPECIALITY'=>$LibraryReport['Speciality'],
            'DISCIPLINECODE'=>$LibraryReport['DisciplineCode'],
            'DISCIPLINE'=>$LibraryReport['Discipline'],
            'FGOS'=>$LibraryReport['FGOS'],
            'COMPILER' => $LibraryReport['Compiler'],
            'CREATEDATE' => $LibraryReport['CreateDate'],
            'LITERATURE' => $Literature,
            'STATUS' => '00',
            'UPDATEDATE' => $LibraryReport['CreateDate'],
            'ADDEDINFINALLIBRARYREPORT' => '0',
        ];
        //Выполняем запрос на запись в БД
        if (DB::insert($QUERY,$VALUES)) {
            echo "Новая справка успешно добавленна в базу данных";
        } else {
            echo "Не удалось записать справку в базу данных";
        }
        exit();
    }

    /*
    public function index() {
        print_r(Session::get('LibraryReportDiscLocal.Creating'));
    }
    */
}
