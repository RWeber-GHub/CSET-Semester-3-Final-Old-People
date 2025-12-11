<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    public function index()
    {
        if (!session()->has('userid') || session('roleid') != 6){
            return redirect('/login');
        }

        return view('supervisorHome');
    }
}
