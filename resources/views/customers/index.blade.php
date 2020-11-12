@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">All Customers</div>
        <div class="card-body">
          @if(count($customers))
          @foreach($customers as $customer)
          <div class="d-flex justify-content-between">
            <p>Customer name: <b>{{ $customer->name }}</b>, His email is: <b>{{ $customer->email }}</b></p>
            <button type="button" data-target="#customer_{{ $customer->id }}" class="btn btn-sm btn-primary mt-1" data-toggle="modal">
              Actions
            </button>
            @include('actionCustomersModal', ['id' => $customer->id, 'name' => $customer->name])
          </div>
          @endforeach
          @else
          <p>There's no customers in our database, <a href="{{ route('customers.create') }}">Create new</a></p>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
