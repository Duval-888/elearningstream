<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function apprenants()
    {
        return view('admin.apprenants'); // Assure-toi que cette vue existe
    }

    public function formateurs()
{
    return view('admin.formateurs'); // Assure-toi que cette vue existe
}

}
