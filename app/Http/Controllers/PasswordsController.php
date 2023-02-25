<?php

namespace App\Http\Controllers;

use App\Models\Password;
use Illuminate\Http\Request;

class PasswordsController extends Controller
{
    public function store()
    {
        $password = new Password();
        return response($password->generate());
    }
}
