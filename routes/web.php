<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('/login');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/employees', 'EmployeesController@index')->name('employees.index');
Route::get('/employee/create', 'EmployeesController@create')->name('employees.create');
Route::post('/employee', 'EmployeesController@store')->name('employees.store');
Route::get('/employee', function(){
    return abort('404');
});

Route::get('/customers', 'CustomersController@index')->name('customers.index');
Route::get('/customers/create', 'CustomersController@create')->name('customers.create');
Route::post('/customers', 'CustomersController@store')->name('customers.store');

Route::post('/customers/action-name', 'CustomerActionController@actionName')->name('customers.action-name');
