<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 07.06.2019
 * Time: 13:48
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Authenticate extends Model
{
    public function checkUser($auth_name) {
        //Ищем FIO в базе сотрудников
        /* FFULLNAME    -   ФИО
        *  FFULLDEPARTMENT  -   Название департамента
        *  FNAMEHEADDEPARTMENT  -   Полное название департамента
        */
        $auth_name = htmlspecialchars(trim($auth_name));
        if ($Auth = DB::selectOne('SELECT FFULLNAME, FFULLDEPARTMENT, FNAMEHEADDEPARTMENT FROM MV_PERSON_WORK WHERE FFULLNAME LIKE :auth_name', ['auth_name' => $auth_name])) {
            //Проверяем что ФИО относится к сотрудникам библиотеки
            (strpos($Auth->ffulldepartment, "Библиотека")) ? Session::put('Authenticate.position', 'library') : Session::put('Authenticate.position', 'none');
            //Заносим данные пользователя в сессию
            Session::put('Authenticate.department', $Auth->ffulldepartment);
            Session::put('Authenticate.name', $Auth->ffullname);
            Session::save();
            return true;
        } else {
            return false;
        }
    }

}