@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">All Customers</div>
        <div class="card-body">
          @foreach($customers as $customer)

          <div class="d-flex justify-content-between">
            <p>Customer name: <b>{{ $customer->name }}</b>, This email is: <b>{{ $customer->email }}</b></p>
            <button type="button" data-target="#customer_{{ $customer->id }}" class="btn btn-sm btn-primary mt-1" data-toggle="modal">
              Actions
            </button>
            @include('actionCustomersModal', ['id' => $customer->id, 'name' => $customer->name])
          </div>

          @endforeach
          <p></p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
