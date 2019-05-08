<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibraryReport extends Model
{
    // Метод получения направлений по годам набора
    public function initializeTraits() {

        $sql = "ALTER SESSION SET NLS_LANGUAGE='RUSSIAN'";
        $this->di->get('db')->query($sql);
        $sql = "ALTER SESSION SET NLS_TERRITORY='CIS'";
        $this->di->get('db')->query($sql);

    }
    //
}
