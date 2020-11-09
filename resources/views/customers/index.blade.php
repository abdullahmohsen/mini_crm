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
            <input type="hidden" name="" id="" value="{{ $customer->id }}">
            <p>Customer name: <b>{{ $customer->name }}</b>, This email is: <b>{{ $customer->email }}</b></p>

            <div class="dropdown">
              <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Actions
              </a>

              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" name="action_name">
                <a class="dropdown-item" value="1" @if($customer_action) selected @endif>Call</a>
                <a class="dropdown-item" value="2">Visit</a>
                <a class="dropdown-item" value="3">Follow up</a>
              </div>
            </div>

            <button type="button" class="btn btn-primary mb-1" data-toggle="modal" data-target="#exampleModal">
              Record
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <textarea name="record" class="form-control"></textarea>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                  </div>
                </div>
              </div>
            </div>

          </div>
          @endforeach
          <p></p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
