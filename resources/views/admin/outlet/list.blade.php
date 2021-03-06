@extends('admin.layouts.app')

@section('content')
@section('page_heading', 'Outlet List')

<div class="row">
  <div class="col-12 mt-2">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Outlet List</h3>
        <div class="card-tools">
          <!-- <a href="javascript:void(0);" class="btn btn-sm btn-warning mr-2"><i class="fas fa-cloud-download-alt"></i>&nbsp;Export</a> -->
          <!-- <a href="javascript:void(0);" id="import" class="btn btn-sm btn-success mr-2"><i class="fas fa-cloud-upload-alt"></i>&nbsp;Import</a> -->
          <a href="{{ url('admin/outlets/create') }}" class="btn btn-sm btn-success mr-2"><i class="fas fa-plus-circle"></i>&nbsp;Add</a>
        </div>
      </div>

      <!-- /.card-header -->
      <div class="card-body table-responsive py-4">
        <table id="table" class="table table-hover text-nowrap table-sm">
          <thead>
            <tr>
              <th>Sr No.</th>
              <th>Outlet No./Code</th>
              <th>Name</th>
              <th>Mobile No.</th>
              <th>Outlet Name</th>
              <th>Type</th>
              <th>State/City</th>
              <th>Available Balance</th>
              <th>Created Date</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->

    </div>
    <!-- /.card -->
  </div>
</div>
<!-- /.row -->

@push('modal')

<!-- Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Import Csv File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Download sample lead Import(CSV) file : <a href="{{ url('admin/order-sample') }}" class="text-green">Download</a></p>
        <form id="import_form" action="{{ url('admin/outlet-import') }}" method="post">
          @csrf

          <div class="form-row">
            <div class="form-group col-md-10">
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" name="file" class="custom-file-input custom-file-input-sm" id="imgInp" accept=".csv">
                  <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                </div>
              </div>
              <span id="file_msg" class="custom-text-danger"></span>
            </div>

            <div class="form-group col-md-2">
              <input type="submit" class="btn btn-success btn-sm" id="submit_bank_charges" value="Import">
            </div>

          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).on('click', '.assign-outlet', function() {
    var outlet_id = $(this).attr('outlet_id');
    $.ajax({
      url: '{{ url("admin/employee-list") }}',
      type: "GET",
      data: {'outlet_id':outlet_id},
      dataType: "JSON",
      success: function(res) {
        $('#assign-outlet').html(res.data);
        $('#outlet_id').val(outlet_id);
        $('#assignModal').modal('show');
      }
    })
  });

  $('#import').click(function(e) {
    e.preventDefault();
    $('form#import_form')[0].reset();
    let url = '{{ url("admin/outlet-import") }}';
    $('form#import_form').attr('action', url);
    $('#importModal').modal('show');
  })


  /*start form submit functionality*/
  $("form#add_bank_charges").submit(function(e) {
    e.preventDefault();
    formData = new FormData(this);
    var url = $(this).attr('action');
    $.ajax({
      data: formData,
      type: "POST",
      url: url,
      dataType: 'json',
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function() {
        $('.has-loader').addClass('has-loader-active');
      },
      success: function(res) {
        //hide loader
        $('.has-loader').removeClass('has-loader-active');

        /*Start Validation Error Message*/
        $('span.custom-text-danger').html('');
        $.each(res.validation, (index, msg) => {
          $(`#${index}_msg`).html(`${msg}`);
        })
        /*Start Validation Error Message*/

        /*Start Status message*/
        if (res.status == 'success' || res.status == 'error') {
          Swal.fire(
            `${res.status}!`,
            res.msg,
            `${res.status}`,
          )
        }
        /*End Status message*/

        //for reset all field
        if (res.status == 'success') {
          $('form#add_bank_charges')[0].reset();
          setTimeout(function() {
            location.reload();
          }, 2000)

        }
      }
    });
  });

  /*end form submit functionality*/
</script>

@endpush

@push('custom-script')

<script type="text/javascript">
  $(document).ready(function() {

    $('#table').DataTable({
      lengthMenu: [
        [10, 30, 50, 100, 500],
        [10, 30, 50, 100, 500]
      ], // page length options

      bProcessing: true,
      serverSide: true,
      scrollY: "auto",
      scrollCollapse: true,
      'ajax': {
        "dataType": "json",
        url: "{{ url('admin/outlets-ajax') }}",
        data: {}
      },
      columns: [{
          data: "sl_no"
        },
        {
          data: 'outlet_no'
        },
        {
          data: "name"
        },
        {
          data: 'mobile_no'
        },
        {
          data: 'outlet_name'
        },
        {
          data: 'type'
        },
        {
          data: "state"
        },
        {
          data: "available_blance"
        },
        {
          data: "created_date"
        },
        {
          data: "status"
        },
        {
          data: "action"
        }
      ],

      columnDefs: [{
        orderable: false,
        targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
      }],
    });

    $(document).on('click', '.activeVer', function() {
      var id = $(this).attr('_id');
      var val = $(this).attr('val');
      $.ajax({
        'url': "{{ url('admin/outlets-status') }}",
        data: {
          "_token": "{{ csrf_token() }}",
          'id': id,
          'status': val
        },
        type: 'POST',
        dataType: 'json',
        success: function(res) {
          if (res.val == 1) {
            $('#active_' + id).text('Active');
            $('#active_' + id).attr('val', '0');
            $('#active_' + id).removeClass('badge-danger');
            $('#active_' + id).addClass('badge-success');
          } else {
            $('#active_' + id).text('Inactive');
            $('#active_' + id).attr('val', '1');
            $('#active_' + id).removeClass('badge-success');
            $('#active_' + id).addClass('badge-danger');
          }
          Swal.fire(
            `${res.status}!`,
            res.msg,
            `${res.status}`,
          )
        }
      })

    })

  });
</script>
@endpush

@push('modal')

<!-- Modal -->
<div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Assign Outlet</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="assignOutlet" action="{{ url('admin/assign-outlet') }}" method="post">
          @csrf
          <input type="hidden" name="outlet_id" id="outlet_id">
          <div class="row">
            <div class="col-md-12">

              <div id="assign-outlet">

              </div>
              <div class="form-group text-center">
                <input type="submit" class="btn btn-success btn-sm" value="Submit">
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  /*start form submit functionality*/
  $("form#assignOutlet").submit(function(e) {
    e.preventDefault();
    formData = new FormData(this);
    var url = $(this).attr('action');
    $.ajax({
      data: formData,
      type: "POST",
      url: url,
      dataType: 'json',
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function() {
        $('.has-loader').addClass('has-loader-active');
      },
      success: function(res) {
        //hide loader
        $('.has-loader').removeClass('has-loader-active');

        /*Start Validation Error Message*/
        $('span.custom-text-danger').html('');
        $.each(res.validation, (index, msg) => {
          $(`#${index}_msg`).html(`${msg}`);
        })
        /*Start Validation Error Message*/

        /*Start Status message*/
        if (res.status == 'success' || res.status == 'error') {
          Swal.fire(
            `${res.status}!`,
            res.msg,
            `${res.status}`,
          )
        }
        /*End Status message*/

        //for reset all field
        if (res.status == 'success') {
          $('form#assignOutlet')[0].reset();
          setTimeout(function() {
            location.reload();
          }, 1000)
        }
      }
    });
  });

  /*end form submit functionality*/
</script>

@endpush


@endsection