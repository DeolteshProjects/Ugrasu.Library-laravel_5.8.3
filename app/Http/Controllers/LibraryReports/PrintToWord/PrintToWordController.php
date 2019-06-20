<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 05.06.2019
 * Time: 15:17
 */

namespace App\Http\Controllers\LibraryReports\PrintToWord;


use App\Http\Controllers\Controller;
use App\Models\LibraryReports\PrintToWord\PrintToWord;

class PrintToWordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function printSpecialAction() {
        return ((new PrintToWord())->printSpecial($_POST['Year'],$_POST['SpecialityCode']));
    }

    public function printDiscAction() {
        return ((new PrintToWord())->printDisc($_POST['Year'],$_POST['SpecialityCode'], $_POST['DisciplineCode']));
    }

}