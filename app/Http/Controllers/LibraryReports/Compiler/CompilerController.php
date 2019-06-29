<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 30.05.2019
 * Time: 10:44
 */

namespace App\Http\Controllers\LibraryReports\Compiler;
use App\Http\Controllers\Controller;
use App\Models\LibraryReports\Compiler\Compiler;
use Illuminate\Support\Facades\Session;

class CompilerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createAction() {
        if (Session::has('LibraryReportDiscLocal.Creating')) {
            return ((new Compiler())->updateCreatingLocalLibraryReport($_POST));
        } else {
            return ((new Compiler())->saveCreatingLocalLibraryReport($_POST));
        }
    }

    //Очистка литературы из составляемой БС в сессии
    public function cleanAction() {
        return ((new Compiler())->cleanCreatingLocalLibraryReport());
    }

    //Удаление составляемой бс из сессии
    public function deleteAction() {
        return ((new Compiler())->deleteCreatingLocalLibraryReport());
    }

    //Созранение справки в безе данных
    public function saveAction() {
        return ((new Compiler())->saveCreatingLibraryReportInDB());
    }

    public function getAction() {
        if (Session::has('LibraryReportDiscLocal.Creating')) {
            return view('libraryReports.Compiler.Compiling', ((new Compiler())->getCreatingLocalLibraryReport()));
        } else {
            return redirect(route('Library.home'));
        }
    }

    //Добавление выбранной литературы в составляемую библиографическую справку
    public function addBookAction() {
        //Определение вида литературы и добавление литературы в составляемую справку
        if ($_POST['ViewOfPublication'] == "[Текст]") {
            return ((new Compiler())->addtBookInCreatingLocalLibraryReport($_POST));
        }   else if ($_POST['ViewOfPublication'] == "[Электронный ресурс]") {
            return ((new Compiler())->addeBookInCreatingLocalLibraryReport($_POST));
        }
    }

    //Удаление выбранной литературы из составляемую библиографическую справку
    public function deleteBookAction() {
        if ((isset($_POST['View'])) AND (!empty($_POST['View']))) {
            return ((new Compiler())->deleteBookInCreatingLocalLibraryReport(((int)($_POST['Id'])), $_POST['View']));
        } else {
            return;
        }
    }

    //Редактирование составленной БС
    public function editAction($year, $specialitycode, $disciplinecode, $forma) {
        ((new Compiler())->getLibraryReportForEdit($year, $specialitycode, $disciplinecode, $forma));
        return redirect( route('Compiler.get'));
    }

    //Отображение справки на экран
    public function showAction() {
        if ((isset($_GET['year'])) AND (isset($_GET['speciality'])) AND (isset($_GET['discipline'])) AND (isset($_GET['compiler'])) AND (isset($_GET['createdate']))) {
            $Answer = (new Compiler())->show($_GET['year'], $_GET['speciality'], $_GET['discipline'], $_GET['compiler'], $_GET['createdate']);
            return view ('libraryReports.Compiler.Show')->with([
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

    public function homeAction() {
        if (Session::has('LibraryReportDiscLocal.Creating')) {
            return redirect(route('Compiler.get'));
        } else {
            $LibraryReports = (new Compiler())->getAllFromAllLibraryReportSToPerson((Session::get('Authenticate.name')));
            return view('libraryReports.Compiler.Home')->with([
                    'LibraryReport' => $LibraryReports['LibraryReports'],
                    'CountLibraryReport' => $LibraryReports['Counts']
                ]
            );
        };
    }

}