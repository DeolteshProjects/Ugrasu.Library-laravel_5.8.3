<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 05.06.2019
 * Time: 15:17
 */

namespace App\Http\Controllers\LibraryReports;


use App\Http\Controllers\Controller;
use App\Models\LibraryReports\PrintLibraryReport;

class PrintLibraryReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function printOnlyOneSpecialAction() {
        return ((new PrintLibraryReport())->printOnlyOneSpecial($_POST['Year'],$_POST['SpecialityCode']));
    }

    public function printOnlyOneDiscAction() {
        return ((new PrintLibraryReport())->printOnlyOneDisc($_POST['Year'],$_POST['SpecialityCode'], $_POST['DisciplineCode']));
    }

}