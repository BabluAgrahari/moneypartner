@extends('admin.layouts.app')

@section('content')
@section('page_heading', 'Dashboard')

<style>
  @media only screen and (max-width: 600px) {
    .h-height {
      height: auto !important;
    }

    .btn-r {
      top: 0px !important;
    }
  }

  .btn-r {
    position: relative;
    text-align: center;
    top: 44px;
  }

  .cu-icon {
    width: 34px !important;
  }

  .info-box .info-box-number {
    margin-top: 0rem !important;
  }

  .info-box {
    min-height: 0px !important;
  }
</style>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">


    <div id="accordion">
      <div class="card">
        <div class="card-header p-0" id="headingOne" style="background: #bcb9b9;">
          <h5 class="mb-0">
            <button class="btn btn-link text-dark" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              <b>Statics</b>
            </button>
          </h5>
        </div>

        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
          <div class="p-2">
            <div class="row">

              <div class="col-6 col-sm-6 col-md-2">

                <div class="info-box">
                  <span class="info-box-icon cu-icon"><i class="fas fa-store text-secondary"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Outlets Amount</span>
                    <span class="info-box-number">
                      {!! !empty($total_outlet_amount)?mSign($total_outlet_amount):0 !!} || {{ $total_outlet}}
                    </span>
                  </div>
                </div>

              </div>


              <div class="col-6 col-sm-6 col-md-2">
                <div class="info-box">
                  <span class="info-box-icon cu-icon"><i class="fas fa-wallet text-secondary"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Topup Req. Amount</span>
                    <span class="info-box-number">
                      {!! !empty($total_topup)?mSign($total_topup):0 !!} || {{ $ac_topup}}
                    </span>
                  </div>
                </div>
              </div>

              <div class="col-6 col-sm-6 col-md-2">
                <div class="info-box mb-3">
                  <span class="info-box-icon cu-icon"><i class="fas fa-hand-holding-usd text-secondary"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Approved Topup</span>
                    <span class="info-box-number"> {!! !empty($a_topup)?mSign($a_topup):0 !!} || {{ $apc_topup }}</span>
                  </div>
                </div>
              </div>

              <div class="col-6 col-sm-6 col-md-2">
                <div class="info-box">
                  <span class="info-box-icon cu-icon"><i class="fas fa-hand-holding-water text-secondary"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Pending Topup</span>
                    <span class="info-box-number">
                      {!! !empty($p_topup)?mSign($p_topup):0 !!} || {{ $pc_topup }}
                    </span>
                  </div>
                </div>
              </div>


              <div class="col-6 col-sm-6 col-md-2">
                <div class="info-box mb-3">
                  <span class="info-box-icon cu-icon"><i class="fas fa-hand-holding-usd text-secondary"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Rejected Topup</span>
                    <span class="info-box-number"> {!! !empty($r_topup)?mSign($r_topup):0 !!} || {{ $rc_topup }}</span>
                  </div>
                </div>
              </div>

            </div>
            <!-- /.row -->
            <div class="row">
              <div class="clearfix hidden-md-up"></div>
              <div class="col-6 col-sm-6 col-md-2">
                <div class="info-box mb-3">
                  <span class="info-box-icon cu-icon"><i class="fas fa-money-bill-alt text-secondary"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">Payout Req. Amount</span>
                    <span class="info-box-number">{!! !empty($total_trans)?mSign($total_trans):0 !!} || {{ $ac_trans}}</span>
                  </div>
                </div>
              </div>

              <div class="col-6 col-sm-6 col-md-2">
                <div class="info-box mb-3">
                  <span class="info-box-icon cu-icon"><i class="fas fa-money-bill-alt text-secondary"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Approved Payout</span>
                    <span class="info-box-number">{!! !empty($a_trans)?mSign($a_trans):0 !!} || {{ $apc_trans}}</span>
                  </div>
                </div>
              </div>

              <div class="col-6 col-sm-6 col-md-2">
                <div class="info-box mb-3">
                  <span class="info-box-icon cu-icon"><i class="fas fa-money-bill-wave text-secondary"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">Pending Payout</span>
                    <span class="info-box-number">{!! !empty($p_trans)?mSign($p_trans):0 !!} || {{ $pc_trans}}</span>
                  </div>
                </div>
              </div>

              <div class="col-6 col-sm-6 col-md-2">
                <div class="info-box mb-3">
                  <span class="info-box-icon cu-icon"><i class="fas fa-money-bill-alt text-secondary"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Failed Payout</span>
                    <span class="info-box-number">{!! !empty($f_trans)?mSign($f_trans):0 !!} || {{ $fc_trans}}</span>
                  </div>
                </div>
              </div>

              <div class="col-6 col-sm-6 col-md-2">
                <div class="info-box mb-3">
                  <span class="info-box-icon cu-icon"><i class="fas fa-money-bill-wave text-secondary"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Rejected Payout</span>
                    <span class="info-box-number">{!! !empty($r_trans)?mSign($r_trans):0 !!} || {{ $rc_trans}}</span>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>


      </div>
    </div>
    <!-- Transaction Request List -->
    @include('admin.dashboard.all_transaction')


    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <!-- <section class="col-lg-7 connectedSortable">

        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Bar Chart</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="chart">
              <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
          </div>

        </div>

      </section> -->
      <!-- /.Left col -->
      <!-- right col (We are only adding the ID to make the widgets sortable)-->
      <!-- <section class="col-lg-5 connectedSortable">

        <div class="card" style="height: 338px;">
          <div class="card-header">
            <h3 class="card-title">Statics</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-md-8">
                <div class="chart-responsive">
                  <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                      <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                      <div class=""></div>
                    </div>
                  </div>
                  <canvas id="pieChart" height="147" width="296" style="display: block; height: 118px; width: 237px;" class="chartjs-render-monitor"></canvas>
                </div>

              </div>

              <div class="col-md-4">
                <ul class="chart-legend clearfix">
                  <li><i class="far fa-circle text-danger"></i> Topup Amount</li>
                  <li><i class="far fa-circle text-success"></i> DMT Amount</li>
                  <li><i class="far fa-circle text-warning"></i> Total DMT Amount</li>
                  <li><i class="far fa-circle text-info"></i> Outlets</li>

                </ul>
              </div>

            </div>

          </div>

        </div>

      </section> -->

    </div>
  </div>
  </div>
</section>
<!-- /.content -->

@push('custom-script')

@endpush

@endsection