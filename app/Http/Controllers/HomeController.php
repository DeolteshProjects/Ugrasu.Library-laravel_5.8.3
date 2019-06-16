<?php

namespace App\Http\Controllers;

use App\Models\LibraryReports\Compiler\Compiler;
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
            return redirect( route('LibraryReportDiscLibraryCompiled.getAllOnlyNew'));
        } else {
            if (Session::has('LibraryReportDiscLocal.Creating')) {
                return redirect(route('Compiler.getCreatingLocalLibraryReport'));
            } else {
                $LibraryReports = (new Compiler())->getAllFromAllLibraryReportSToPerson((Session::get('Authenticate.name')));
                return view('home')->with([
                        'LibraryReport' => $LibraryReports['LibraryReports'],
                        'CountLibraryReport' => $LibraryReports['Counts']
                    ]
                );
            };
        }

    }
}
