<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 30.05.2019
 * Time: 22:19
 */

namespace App\Http\Controllers\LibraryReports\Library;

use App\Http\Controllers\Controller;
use App\Models\LibraryReports\Library\Library;

class LibraryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Получение только новых библиографических справок
    public function getAllNewAction() {
        return view('libraryReports.Library.CompiledNew')
            ->with([
                'data' => ((new Library())->getAllNew())
            ]);
    }

    //Получение только принятых библиографических справок
    public function getAllSuccessAction() {
        return view('libraryReports.Library.CompiledSuccess')
            ->with([
                'data' => ((new Library())->getAllSuccess())
            ]);
    }

    //Получение только принятые библиографических справок
    public function getAllDangerAction() {
        return view('libraryReports.Library.CompiledDanger')
            ->with([
                'data' => ((new Library())->getAllDanger())
            ]);
    }

    //Получение всех библиографических справок
    public function getAllAction() {
        return view('libraryReports.Library.CompiledAll')
            ->with([
                'data' => ((new Library())->getAll())
            ]);
    }

    public function getCompilingAction() {
        return view('libraryReports.Library.Compiling')
            ->with([
                'data' => ((new Library())->getCompiling())
            ]);
    }

    public function compositionAction($year, $specialitycode) {
        $data =  ((new Library())->getComposition($year,$specialitycode));
        if (empty($data['Created'])) {
            return redirect(route('SqlError'));
        }
        return view('libraryReports.Library.Compositions')
            ->with([
                'data' => $data
            ]);
    }

    //Отображение конкретной библиографической справки
    public function showAction() {
        if ((isset($_GET['year'])) AND (isset($_GET['speciality'])) AND (isset($_GET['discipline'])) AND (isset($_GET['compiler'])) AND (isset($_GET['createdate']))) {
            $Answer = (new Library())->show($_GET['year'], $_GET['speciality'], $_GET['discipline'], $_GET['compiler'], $_GET['createdate']);
            return view ('libraryReports.Library.Show')->with([
                'LibraryReport' => $Answer['LibraryReport'],
                'AmountOfLiterature' => $Answer['AmountOfLiterature'],
                'AmountOftBookLiterature' => $Answer['AmountOftBookLiterature'],
                'tBook' => $Answer['tBook'],
                'AmountOfeBookLiterature' => $Answer['AmountOfeBookLiterature'],
                'eBook' =>  $Answer['eBook'],
                'Activity' => $Answer['Activity']
            ]);
        } else {
            return redirect( route('LibraryReportDiscLibraryCompiled.getAllOnlyNew'));
        }
    }

    //Изменение статуса библиографической справки библиотекой
    public function updateStatusAction() {
        return ((new Library())->updateStatus($_POST));
    }
}