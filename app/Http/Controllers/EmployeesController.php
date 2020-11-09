<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeesController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('authorized:employee');
    }

    public function index() {
        $employee_role_id = Role::where('name', 'employee')->first()->id;
    	$employees = User::where('role_id', $employee_role_id)->get();

        return view('employees.index')->with([
        	'employees' => $employees
        ]);
    }

    public function create() {
    	$user = User::find(Auth::user()->id);

        return view('employees.create')->with([
        	'user' => $user
        ]);
    }

    public function store(Request $request) {
    	$data = $request->all();

    	$max_role_count = Role::select('*')->count();
    	\Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'integer', "min:1", "max:$max_role_count"],
        ]);

        $employee_role_id = Role::where('name', 'employee')->first()->id;
        $employee = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $employee_role_id,
        ]);

        // Log section
        $user_log = new UserLog;
        $user_log->user_id = Auth::user()->id;
        $user_log->action_name = 'create employee';
        $user_log->payload = "
        	Employee ID (". $employee->id . ") -
        	Employee name: (". $employee->name . ")
        ";
        $user_log->save();

        return redirect()->route('home');
    }
}
