<?php

namespace App\Http\Controllers;

use App\CustomerAction;
use App\EmployeeAssignation;
use App\Http\Requests\CustomerRequest;
use App\Role;
use App\User;
use App\UserLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class CustomersController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('authorized:customer');
    }

    public function index() {
        $customer_action = CustomerAction::get();
        $role = Auth::user()->role->name;

        if($role == 'super_admin') {
	        $customer_role_id = Role::where('name', 'customer')->first()->id; //role_id for customer
    	    $customer_employee = User::where('role_id', $customer_role_id)->get(); //get all data of all customer
        } elseif ($role == 'employee') {
            $employee_role_id = Auth::user()->id; //employee id
            $customers_id = EmployeeAssignation::where('employee_id', $employee_role_id)->get('customer_id'); //get all customers of employee
            $customer_employee = User::whereIn('id', $customers_id)->get();
        }


        return view('customers.index')->with([
        	'customers' => $customer_employee,
        	'customer_action' => $customer_action,
        ]);
    }

    public function create() {

        $role = Auth::user()->role->name;

        if($role == 'super_admin') {
	        $employee_role_id = Role::where('name', 'employee')->first()->id; //role_id for employee
    	    $employees = User::where('role_id', $employee_role_id)->get()->toArray(); //get all data of all employee
        } elseif ($role == 'employee') {
            $employee_role_id = Auth::user()->id;
            $employees = User::where('id', $employee_role_id)->get()->toArray(); //get all data of all employee
        }

        return view('customers.create')->with([
        	'user' => Auth::user(),
        	'employees' => $employees,
        ]);
    }

    public function store(CustomerRequest $request) {

        $data = $request->all();

        $customer_role_id = Role::where('name', 'customer')->first()->id;
        $customer = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $customer_role_id,
        ]);

        $user = User::find(Auth::user()->id);
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
        	Customer ID (" . $customer->id . ") -
        	Customer name: (" . $customer->name . ")
        	Assigned to Employee ID (". $assign_to_employee->id . ") -
        	Employee name: (". $assign_to_employee->name . ")
        ";
        $user_log->save();
        return redirect()->route('home');
    }
}





