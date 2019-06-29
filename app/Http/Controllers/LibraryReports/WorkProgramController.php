<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 29.05.2019
 * Time: 23:57
 */

namespace App\Http\Controllers\LibraryReports;

use App\Http\Controllers\Controller;
use App\Models\LibraryReports\WorkProgram;
use App\Models\LibraryReports\Compiler;


class WorkProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    //Получение Сппециальностей/Направлений обучения
    public function getSpecialityAction()
    {
        return ((new WorkProgram())->getSpeciality($_POST['year']));
    }

    //Получение формы обучения
    public function getFormAction()
    {
        //Проверяем не была ли до этого момента составленна эта БС
        return ((new WorkProgram())->getForms($_POST['speciality'], $_POST['year']));
    }

    //Получение дисциплин
    public function getDisciplineAction()
    {
        //Проверяем не была ли до этого момента составленна эта БС
        return ((new WorkProgram())->getDisciplines($_POST['speciality'], $_POST['year'], $_POST['forma']));
    }

    //Получение семестров
    public function getSemesterAction()
    {
        //Проверяем не была ли до этого момента составленна эта БС
        return ((new WorkProgram())->getSemesters($_POST['speciality'], $_POST['year'], $_POST['forma'], $_POST['discipline']));
    }

    //Получение ФГОСов
    public function getFGOSAction()
    {
        return ((new WorkProgram())->getFGOS($_POST['speciality']));
    }
}