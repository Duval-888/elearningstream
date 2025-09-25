<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function apprenants()
{
    $users = User::where('role', 'apprenant')->latest()->paginate(15);
    return view('admin.apprenants', compact('users'));
}

public function formateurs()
{
    $users = User::where('role', 'formateur')->latest()->paginate(15);
    return view('admin.formateur', compact('users'));
}

}
