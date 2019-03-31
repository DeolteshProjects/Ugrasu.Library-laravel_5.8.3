<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemporaryStorageController extends Controller
{
    //
    public function index() {

       print_r($_POST);
            echo "Я получил айдишку";
        echo  "Я не получил айдишку";

    }
}
