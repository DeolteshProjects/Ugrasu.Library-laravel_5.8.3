<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Session::get('Authenticate.position') == 'library') {
            return redirect( route('Library.home'));
        } else {
                return redirect(route('Compiler.home'));
        }
    }
}
