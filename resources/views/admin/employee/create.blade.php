@extends('admin.layouts.app')

@section('content')
@section('page_heading', 'Create Employee')

<div class="cover-loader d-none">
    <div class="loader"></div>
</div>

<div id="employee">

    <form id="add-employee" action="{{ url('admin/employee') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">


            <div class="col-md-6 ml-auto mt-1 mr-auto">
                <!-- Form Element sizes -->
                <div class="card card-secondary">
                    <div class="card-header card-custom-header">
                        <h3 class="card-title">Create Employee</h3>
                    </div>

                    <div class="card-body">

                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" id="avatar" src="{{ asset('assets') }}/dist/img/user4-128x128.jpg" alt="User profile picture">
                        </div>

                        <div class="form-group">
                            <label>Profile Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="employee" class="custom-file-input custom-file-input-sm" id="imgInp" accept="image/png, image/gif, image/jpeg">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                            </div>
                            <span id="employee_msg" class="custom-text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="full_name" class="form-control form-control-sm" placeholder="Full Name">
                            <span id="full_name_msg" class="custom-text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label>Email Id</label>
                            <input type="text" name="email" class="form-control form-control-sm" placeholder="Enter Email">
                            <span id="email_msg" class="custom-text-danger"></span>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Mobile Number</label>
                                <input type="text" name="mobile_no" class="form-control form-control-sm" placeholder="Mobile No">
                                <span id="mobile_no_msg" class="custom-text-danger"></span>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Gender</label>
                                <select class="form-control form-control-sm" name="gender">
                                    <option value="">Select</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                                <span id="gender_msg" class="custom-text-danger"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" id="address" name="address" placeholder="Enter Address" rows="5"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control form-control-sm" placeholder="Enter Password">
                            <span id="password_msg" class="custom-text-danger"></span>
                        </div>


                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Role</label>
                                <select class="form-control form-control-sm" name="role" required>
                                    <option value="">Select</option>
                                    <option value="employee">Employee</option>
                                    <option value="admin">Admin</option>
                                </select>
                                <span id="role_msg" class="custom-text-danger"></span>
                            </div>

                            <div class="form-group col-md-6">
                                <label> Status</label>
                                <select class="form-control form-control-sm" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <span id="account_status_msg" class="custom-text-danger"></span>
                            </div>
                        </div>

                        <div class="">
                            <input type="submit" value="Submit" class="btn btn-sm btn-success">
                            <a href="{{ url('admin/employee') }}" class="btn btn-sm btn-warning">Back</a>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
            </div>

        </div>
    </form>
</div>

@push('custom-script')
<script>
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
                }
            }
        });
    });

    /*end form submit functionality*/
</script>
@endpush

@endsection