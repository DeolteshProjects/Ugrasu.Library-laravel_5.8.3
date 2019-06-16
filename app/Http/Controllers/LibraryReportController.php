<?php

namespace App\Http\Controllers;

use App\Models\LibraryReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\LibraryReportDisc;

class LibraryReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('libraryReports.createFrom');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function seed() {
        //
        if (Session::has('libraryList.number')) {
            $number = Session::get('libraryList.number');
            $report = Session::get('libraryList');
            $Anketa = Session::get('LibraryReportDiscLocal.Creating');

            return view('libraryReports.seed', [
                'num' => $number,
                'report' => $report,
                'Anketa' => $Anketa
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LibraryReport  $libraryReport
     * @return \Illuminate\Http\Response
     */
    public function show(LibraryReport $libraryReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LibraryReport  $libraryReport
     * @return \Illuminate\Http\Response
     */
    public function edit(LibraryReport $libraryReport)
    {

        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LibraryReport  $libraryReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LibraryReport $libraryReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LibraryReport  $libraryReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(LibraryReport $libraryReport)
    {
        //
    }
}
