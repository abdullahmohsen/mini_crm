@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">All employees</div>

                <div class="card-body">
                    <div>
                        @foreach($employees as $employee)
                            <p>Employee name: <b>{{ $employee->name }}</b>, This email is: <b>{{ $employee->email }}</b></p>
                        @endforeach
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
