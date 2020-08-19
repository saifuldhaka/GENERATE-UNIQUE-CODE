@extends('layouts.layout')
@section('content')

<div class="col-12 col-md-8" style="margin: 0 auto;text-align: center;">
  <div class="row mt-4 mb-3">
      <div class="col-12">
          <h4 class="uppercase font-palatino-bold">GENERATE UNIQUE CODE</h4>
      </div>
  </div>
</diV>
<div class="col-12 col-md-4" style="margin: 0 auto;">
    <div class="card" id="form-card">
        <div class="card-body">
            <div class="form-group">
                <label class="text-color-primary"> No Of Code: </label>
                <input type="number" min="0" class="form-control " id="no_of_code" />
              </div>
              <div class="form-group">
                <button type="button" class="btn btn-primary btn-block" id="generateCode">Generate Code</button>
              </div>

              <div id="overlay" style="display: none;">
                  <div class="w-100 d-flex justify-content-center align-items-center">
                    <div class="spinner"></div>
                    <p>Processing...</p>
                  </div>
              </div>

        </div>
    </div>

    <div class="card" id="report-card" style="display: none; margin-top: 20px;">
        <div class="card-body">
          <div class="col-12">
              <h4 class="uppercase font-palatino-bold">GENERATE UNIQUE CODE REPORT</h4>
          </div>
            <div class="form-group">
              <label class="text-color-primary"> Start Time: </label>
              <input type="text" class="form-control " id="start_time" readonly />
            </div>
            <div class="form-group">
              <label class="text-color-primary"> End Time: </label>
              <input type="text" class="form-control " id="end_time" readonly/>
            </div>
            <div class="form-group">
              <label class="text-color-primary"> Processting Time: </label>
              <input type="text" class="form-control " id="processing_time" readonly />
            </div>

        </div>
    </div>


</div>

@endsection
@section('scripts')

<script>

    $("#generateCode").click(function () {
        var noOfCode = $("#no_of_code").val();
        if (noOfCode > 0 )
        {
            $('#report-card').hide();
            $('#overlay').show();

            $.ajax({
                type: 'POST',
                url: "http://localhost:8001/new-code",
                data: {
                    _token: '{!! csrf_token() !!}',
                    no_of_code: noOfCode
                },
                success: function (data) {
                    $('#overlay').hide();
                    $('#report-card').show();
                    var response = data.response;
                    $("#start_time").val(response.start_time);
                    $("#end_time").val(response.end_time);
                    $("#processing_time").val(response.process_time);
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'No Of Code is required',
                customClass: 'custom-alert-popup',
                confirmButtonColor: "#d2a299"
            })
        }
    });


</script>
@endsection
