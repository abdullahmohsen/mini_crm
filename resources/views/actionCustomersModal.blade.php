<!-- Action Modal -->
<div class="modal fade" id="customer_{{ $id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header mb-2">
        <h5 class="modal-title" id="exampleModalLabel">Actions for {{ $name }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="m-auto text-center">
        <div id="" class="text-center alert alert-success msgSuccess"></div>
        <div id="" class="text-center alert alert-danger msgErrors"></div>
      </div>
      <form id="{{ $id }}" action="#" class="createActionCustomer_{{ $id }}">
        @csrf
        <input type="hidden" name="customer_id" value="{{ $id }}">
        <div class="modal-body">
          <div class="form-group">
            <label>Actions:</label>
            <select class="custom-select mr-sm-2" id="actionName" name="action_name{{ $id }}">
              <option value="0">Choose...</option>
              <option value="call">Call</option>
              <option value="visit">Visit</option>
              <option value="follow">Follow Up</option>
            </select>
          </div>
          <div class="form-group">
            <label>Record:</label>
            <textarea class="form-control recordData" name="record{{ $id }}" cols="30" rows="5"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <a id="" class="btn btn-primary addAction" data-id={{ $id }}>Add</a>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Ajax -->
@section('Scripts')
<script>
  $('.msgSuccess').hide()
  $('.msgErrors').hide()

  $(".addAction").on('click', function(e) {
    var target = $(this).data('id');
    e.preventDefault();
    $('.msgSuccess').hide()
    $('.msgErrors').hide()
    $('.msgErrors').empty()
    var action = $("select[name='action_name" + target + "']").val();
    var record = $("textarea[name='record" + target + "']").val();
    $.ajax({
      type: 'POST',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{ route('customers.action-name') }}",
      data: {
        '_token': "{{ csrf_token() }}",
        'customer_id': target,
        'action_name': action,
        'record': record,
      },
      cache: false,
      success: function(data) {
        //console.log(data.success);
        $('.msgSuccess').show()
        $('.msgSuccess').text(data.success);
        setTimeout(function() {
          $('.msgSuccess').fadeOut('fast');
        }, 3000);
        location.reload();
      },
      error: function(xhr, status, error) {
        {
          $('.msgErrors').show()
        }
        $.each(xhr.responseJSON.errors, function(key, item) {
          $('.msgErrors').append("<p class='mb-0'>" + item + "</p>")
          setTimeout(function() {
            $('.msgErrors').fadeOut('fast');
          }, 3000);
        })
      }
    })
  });

</script>

@endsection
