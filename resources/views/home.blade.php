@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-9">
      <div class="card">
        <div class="card-header">{{ __('Dashboard') }}</div>

        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif

          <div class="mb-3">
            Your email: <b>{{ $user->email }}</b>
          </div>
          <div class="mb-3">
            Your role: <b>{{ $user->role->title }}</b>
          </div>

          <div class="mb-3">
            @if (auth()->user()->role->name == 'super_admin')
              <a class="btn btn-sm btn-success mr-3" href="{{ route('employees.create') }}">Create Employee</a>
            @else
              <a class="btn btn-sm btn-success mr-3 disabled" href="{{ route('employees.create') }}">Create Employee</a>
            @endif

            @if (auth()->user()->role->name == 'super_admin' || auth()->user()->role->name == 'employee')
                <a class="btn btn-sm btn-primary" href="{{ route('customers.create') }}">Create Customer</a>
            @else
                <a class="btn btn-sm btn-primary disabled" href="{{ route('customers.create') }}">Create Customer</a>
            @endif
          </div>
          <div class="mb-3">
            @if (auth()->user()->role->name == 'super_admin')
                <a class="btn btn-sm btn-success mr-3" href="{{ route('employees.index') }}">Show Employees</a>
            @else
                <a class="btn btn-sm btn-success mr-3 disabled" href="{{ route('employees.index') }}">Show Employees</a>
            @endif

            @if (auth()->user()->role->name == 'super_admin' || auth()->user()->role->name == 'employee')
                <a class="btn btn-sm btn-primary" href="{{ route('customers.index') }}">Show Customers</a>
            @else
                <a class="btn btn-sm btn-primary disabled" href="{{ route('customers.index') }}">Show Customers</a>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-9 mt-4">
      <div class="card">
        <div class="card-header">{{ __('Assignation Customers') }}</div>

        <div class="card-body">
          <div class="mb-3">
            @foreach($user_log as $index => $user)
            <p>{{ $index + 1 }}. {{ $user->payload }}</p>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
