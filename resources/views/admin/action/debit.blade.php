@extends('admin.layouts.app')
@section('content')


<div class="cover-loader d-none">
    <div class="loader"></div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card-body table-responsive py-2 table-sm">
            <table id="table" class="table table-hover text-nowrap table-sm">
                <thead>
                    <tr>
                        <th>Outlet</th>
                        <th>Transaction Id</th>
                        <th>Channel</th>
                        <th>Amount</th>
                        <th>Datetime</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($credits as $credit)
                    <tr>
                        <td><a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="{{ $credit->remark }}">{{ !empty($credit->RetailerName['outlet_name']) ? $credit->RetailerName['outlet_name'] : '' }}</a></td>
                        <td>{{ $credit->transaction_id }}</td>
                        <td>{{ $credit->channel}}</td>
                        <td>{!!mSign($credit->amount)!!}</td>
                        <td>{{ date('d M y H:i A')}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-4">
        <div id="employee">
            <form id="add-employee" action="{{ url('admin/debit') }}" method="post" enctype="multipart/form-data">
                @csrf
                <!-- Form Element sizes -->
                <div class="card card-secondary">
                    <div class="card-header card-custom-header">
                        <h3 class="card-title">Manual Debit</h3>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label>Outlet Name</label>
                            <select class="form-control form-control-sm" name="retailer_id" id="outlet_id">
                                <option value="">Select</option>
                                @foreach($outlets as $outlet)
                                <option value="{{ $outlet->_id }}">{{ ucwords($outlet->outlet_name)}}</option>
                                @endforeach
                            </select>
                            <span id="outlet_name_msg" class="custom-text-danger"></span>
                        </div>

                        <div id="outlet-blance">

                        </div>

                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" name="amount" class="form-control form-control-sm" placeholder="Enter Amount" required>
                            <span id="amount_msg" class="custom-text-danger"></span>
                        </div>
                         <div class="form-group">
                            <label>Payment Channel</label>
                            <select name="payment_channel" class="form-control form-control-sm" id="payment_channel">
                                <option value="">Select</option>
                                <?php foreach ($payment_channel as $channel) {
                                    echo '<option value="' . $channel->name . '">' . $channel->name . '</option>';
                                } ?>
                            </select>
                            <span id="payment_channel_msg" class="custom-text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Remarks</label>
                            <textarea class="form-control" id="remark" name="remark" placeholder="Enter Remarks" rows="2"></textarea>
                        </div>

                        <div class="">
                            <input type="submit" value="Submit" class="btn btn-sm btn-success">
                            <a href="{{ url('admin/debit') }}" class="btn btn-sm btn-warning">Back</a>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
            </form>
        </div>
    </div>
</div>


@push('custom-script')
<script>
    $('#outlet_id').change(function() {

        var oultlet_id = $(this).val();
        $.ajax({
            url: '{{ url("admin/debit-show") }}/' + oultlet_id,
            type: "GET",
            dataType: "json",
            success: function(res) {
                $('#outlet-blance').html('<div class="form-group"><label>Available Balance</label><div>' + res.amount + '</div></div>');
            }
        });
    })

    /*start form submit functionality*/
    $("form#add-employee").submit(function(e) {
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
                $('.cover-loader').removeClass('d-none');
                $('#employee').hide();
            },
            success: function(res) {
                //hide loader
                $('.cover-loader').addClass('d-none');
                $('#employee').show();

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
                    $('form#add-employee')[0].reset();
                    $('#custom-file-label').html('');
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