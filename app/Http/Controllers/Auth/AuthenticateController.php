<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 07.06.2019
 * Time: 13:23
 */

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\Authenticate;

class AuthenticateController extends Controller
{

    public function getLoginFormAction()
    {
        if (!Session::has('Authenticate')) {
            return view('auth.login');
        } else {
            return redirect(route('home'));
        }
    }

    public function loginAction($auth_name)
    {
        if (!Session::has('Authenticate')) {
            if (!empty($auth_name)) {
                //Придумать проверку что это реально ФИО
                $Auth = (new Authenticate())->checkUser($auth_name);
                if ($Auth != NULL) {
                    return redirect(route('home'));
                } else {
                    return view('auth.login');
                }
            } else {
                return view('auth.login');
            }
        } else {
            return redirect(route('home'));
        }
    }

    public function logoutAction()
    {
        if (Session::has('Authenticate')) {
            Session::flush();
            Session::save();
            return redirect(route('getLoginForm'));
        } else {
            return redirect(route('home'));
        }
    }

}