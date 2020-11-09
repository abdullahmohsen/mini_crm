<?php

namespace App\Http\Controllers;

use App\EmployeeAssignation;
use App\User;
use App\UserLog;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = User::find(\Auth::user()->id);

        // return $EmployeeAssignation = EmployeeAssignation::get();
        $user_log = UserLog::where('action_name', 'create customer')->get();

        return view('home')->with([
            'user' => $user,
            'user_log' => $user_log
        ]);
    }
}
