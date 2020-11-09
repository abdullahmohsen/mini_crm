<?php

namespace App\Http\Controllers;

use App\CustomerAction;
use App\EmployeeAssignation;
use App\Role;
use App\User;
use App\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomersController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('authorized:customer');
    }

    public function index() {
        $customer_role_id = Role::where('name', 'customer')->first()->id;
        $customers = User::where('role_id', $customer_role_id)->get();


        // $customer_id = ;

        $customer_action = CustomerAction::get();
        // return $customer_action = CustomerAction::where('customer_id', $customer->id)->get();

        return view('customers.index')->with([
        	'customers' => $customers,
        	'customer_action' => $customer_action,
        ]);
    }

    public function create() {

        $user = User::find(Auth::user()->id);
        $role = $user->role->name;

        if($role == 'super_admin') {
	        $employee_role_id = Role::where('name', 'employee')->first()->id; //role_id for employee
    	    $employees = User::where('role_id', $employee_role_id)->get()->toArray(); //get all data of all employee
        } elseif ($role == 'employee') {
            $employee_role_id = User::find(Auth::user()->id)->id;
    	    $employees = User::where('id', $employee_role_id)->first()->toArray(); //get all data of all employee
        }
        $user = User::find(Auth::user()->id); //user data login

        return view('customers.create')->with([
        	'user' => $user,
        	'employees' => $employees,
        ]);
    }

    // public function create() {
    // 	$employee_role_id = Role::where('name', 'employee')->first()->id;
    // 	$employees = User::where('role_id', $employee_role_id)->get()->toArray();
    // 	$user = User::find(Auth::user()->id);

    //     return view('customers.create')->with([
    //     	'user' => $user,
    //     	'employees' => $employees,
    //     ]);
    // }

    public function store(Request $request) {
    	$data = $request->all();

    	$max_role_count = Role::select('*')->count();
    	\Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'integer', "min:1", "max:$max_role_count"],
            'assignation_employee_id' => ['required', 'integer', "min:1"],
        ]);

        $customer_role_id = Role::where('name', 'customer')->first()->id;
        $customer = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $customer_role_id,
        ]);

        $user = User::find(\Auth::user()->id);
        $role = $user->role->name;

        // Assignation section
        $EmployeeAssignation = new EmployeeAssignation;
        $assign_to_employee = null;
        if($role == 'super_admin') {
	        $EmployeeAssignation->employee_id = $data['assignation_employee_id'];
	        $assign_to_employee = User::find($data['assignation_employee_id']);
        } elseif ($role == 'employee') {
	        $EmployeeAssignation->employee_id = $user->id;
	        $assign_to_employee = User::find($user->id);
        }
        $EmployeeAssignation->customer_id = $customer->id;
        $EmployeeAssignation->save();

        // Log section
        $user_log = new UserLog;
        $user_log->user_id = Auth::user()->id;
        $user_log->action_name = 'create customer';
        $user_log->payload = "
        	Customer ID (" . $customer->id . ")<br>
        	Customer name: (" . $customer->name . ")<br>
        	Assigned to Employee ID (". $assign_to_employee->id . ") -
        	Employee name: (". $assign_to_employee->name . ")
        ";
        $user_log->save();

        return redirect()->route('home');
    }
}
