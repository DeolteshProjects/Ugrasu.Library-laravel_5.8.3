<?php

namespace App;

use Illuminate\Support\Facades\Session;

class User extends Authenticatable
{
    public function logout() {
        Session::flush();
        return redirect('/login');
    }
}
