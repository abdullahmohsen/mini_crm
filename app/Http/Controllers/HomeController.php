<?php

namespace App\Http\Controllers;

use App\User;
use App\UserLog;
use App\EmployeeAssignation;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = User::find(Auth::user()->id);
        $user_log = UserLog::where('action_name', 'create customer')->get();
        $roles_name = Role::get();

        $roles_name = auth()->user()->role->name;

        return view('home')->with([
            'user' => $user,
            'user_log' => $user_log,
            'roles_name' => $roles_name
        ]);
    }
}
