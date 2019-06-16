<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 30.05.2019
 * Time: 22:19
 */

namespace App\Http\Controllers\LibraryReports;

use App\Http\Controllers\Controller;
use App\Models\LibraryReports\LibraryReportDiscLibrary;

class LibraryReportDiscLibraryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    

    //Получение только новых библиографических справок
    public function getAllNewAction() {
        return view('libraryReports.LibraryCompiledNewLibraryReports')
            ->with([
                'data' => ((new LibraryReportDiscLibrary())->getAllNew())
            ]);
    }

    //Получение только принятых библиографических справок
    public function getAllSuccessAction() {
        return view('libraryReports.LibraryCompiledSuccessLibraryReports')
            ->with([
                'data' => ((new LibraryReportDiscLibrary())->getAllSuccess())
            ]);
    }

    //Получение только принятые библиографических справок
    public function getAllDangerAction() {
        return view('libraryReports.LibraryCompiledDangerLibraryReports')
            ->with([
                'data' => ((new LibraryReportDiscLibrary())->getAllDanger())
            ]);
    }

    //Получение всех библиографических справок
    public function getAllAction() {
        return view('libraryReports.LibraryCompiledAllLibraryReports')
            ->with([
                'data' => ((new LibraryReportDiscLibrary())->getAll())
            ]);
    }

    public function getSuccessSpecAction() {
        return view('libraryReports.LibraryCompiledSuccessSpecLibraryReports')
            ->with([
                'data' => ((new LibraryReportDiscLibrary())->getSuccessSpec())
            ]);
    }

    public function compositionSpecialAction($year, $specialitycode) {
        return view('libraryReports.CompositionLibraryReports')
            ->with([
                'data' => ((new LibraryReportDiscLibrary())->getComposition($year,$specialitycode))
            ]);
    }

    //Отображение конкретной библиографической справки
    public function showLibraryReportAction() {
        if ((isset($_GET['year'])) AND (isset($_GET['speciality'])) AND (isset($_GET['discipline'])) AND (isset($_GET['compiler'])) AND (isset($_GET['createdate']))) {
            $Answer = (new LibraryReportDiscLibrary())->showLibraryReportWithData($_GET['year'], $_GET['speciality'], $_GET['discipline'], $_GET['compiler'], $_GET['createdate']);
            return view ('libraryReports.ShowLibraryReport')->with([
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
    public function updateStatusInLibraryReportDiscAction() {
        return ((new LibraryReportDiscLibrary())->updateStatusInLibraryReportDisc($_POST));
    }
}