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

    public function getCreatingLocalLibraryReportAction() {
        if (Session::has('LibraryReportDiscLocal.Creating')) {
            return view('libraryReports.Compiler.CompilingLibraryReport', ((new Compiler())->getCreatingLocalLibraryReport()));
        } else {
            return redirect(route('home'));
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
    public function editAction($year, $specialitycode, $disciplinecode) {
        ((new Compiler())->getLibraryReportForEdit($year, $specialitycode, $disciplinecode));
        return redirect( route('Compiler.getCreatingLocalLibraryReport'));
    }

}