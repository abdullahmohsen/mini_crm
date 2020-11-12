@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">All employees</div>

        <div class="card-body">
          <div>
            @if(count($employees))
            @foreach($employees as $employee)
            <p>Employee name: <b>{{ $employee->name }}</b>, His email is: <b>{{ $employee->email }}</b></p>
            @endforeach
            @else
            <p>There's no employees in our database, <a href="{{ route('employees.create') }}">Create new</a></p>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
