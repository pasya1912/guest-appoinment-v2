@extends('layout.master')

@push('plugin-styles')
<!-- {!! Html::style('/assets/plugins/plugin.css') !!} -->
@endpush

@section('content')
<div class="row">
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body">
        <div class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
          <div class="float-left">
            <i class="mdi mdi-cube text-danger icon-lg"></i>
          </div>
          <div class="float-right">
            <p class="mb-0 text-right">Total Appointment</p>
            <div class="fluid-container">
              <h3 class="font-weight-medium text-right mb-0">{{ $total_appointment }}</h3>
            </div>
          </div>
        </div>
        <p class="text-muted mt-3 mb-0 text-left text-md-center text-xl-left">
          <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> Approved ticket </p>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body">
        <div class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
          <div class="float-left">
            <i class="mdi mdi-receipt text-warning icon-lg"></i>
          </div>
          <div class="float-right">
            <p class="mb-0 text-right">Total Visitor</p>
            <div class="fluid-container">
              <h3 class="font-weight-medium text-right mb-0">{{ $total_visitor }}</h3>
            </div>
          </div>
        </div>
        <p class="text-muted mt-3 mb-0 text-left text-md-center text-xl-left">
          <i class="mdi mdi-bookmark-outline mr-1" aria-hidden="true"></i> Registered visitor </p>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body">
        <div class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
          <div class="float-left">
            <i class="mdi mdi-poll-box text-success icon-lg"></i>
          </div>
          <div class="float-right">
            <p class="mb-0 text-right">Today Appointment</p>
            <div class="fluid-container">
              <h3 class="font-weight-medium text-right mb-0">{{ $today_appointment }}</h3>
            </div>
          </div>
        </div>
        <p class="text-muted mt-3 mb-0 text-left text-md-center text-xl-left">
          <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i> {{ Carbon\Carbon::parse()->toFormattedDateString() }} </p>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body">
        <div class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
          <div class="float-left">
            <i class="mdi mdi-account-box-multiple text-info icon-lg"></i>
          </div>
          <div class="float-right">
            <p class="mb-0 text-right">Visitor Inside</p>
            <div class="fluid-container">
              <h3 class="font-weight-medium text-right mb-0">{{ $visitor_inside }}</h3>
            </div>
          </div>
        </div>
        <p class="text-muted mt-3 mb-0 text-left text-md-center text-xl-left">
          <i class="mdi mdi-reload mr-1" aria-hidden="true"></i> Visitor inside AIIA </p>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-12 grid-margin">
    <div class="card">
      <div class="card-body p-5">
        <div class="row">
          <div class="col-10">
            <h4 class="card-title mb-5">Total Appointment</h4>
          </div>
          <div class="col-2">
            <button type="submit" class="btn btn-info text-right"><i class="mdi mdi-file-export pr-1"></i>Export</button>
          </div>
        </div>
        <table class="table table-responsive-lg" id="allTicket">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Guest Name</th>
              <th class="text-center">Visit Purpose</th>
              <th class="text-center">Plan Visit</th>
              <th class="text-center">Visit Date</th>
              <th class="text-center">Status</th>
            </tr>
          </thead>
          <tbody class="text-center">
            @if(!$appointments->isEmpty())
              @foreach ($appointments as $appointment)
              
              <tr>
                <td class="display-4">{{ $loop->iteration }}</td>
                <td class="display-4">{{ $appointment->name }}</td>
                <td class="display-4">{{ $appointment->purpose }}</td>
                <td class="display-4">{{ $appointment->frequency }}</td>
                <td class="display-4">{{ Carbon\Carbon::parse($appointment->start_date)->toFormattedDateString() }} - {{ Carbon\Carbon::parse($appointment->end_date)->toFormattedDateString() }}</td>
                
                @if($appointment->status === 'pending')
                  <td>
                    <span class="badge badge-pill badge-warning p-2 text-light">{{ $appointment->status }}</span>
                  </td>
                @elseif($appointment->status === 'approved')
                  <td>
                    <span class="badge badge-pill badge-success p-2 text-light">{{ $appointment->status }}</span>
                  </td>
                @else
                  <td>
                    <span class="badge badge-pill badge-danger p-2 text-light">{{ $appointment->status }}</span>
                  </td>
                @endif

              </tr>
              
              @endforeach
            @else
              <tr>
                <td colspan="7">
                  <h4 class="mt-4">You don't have any ticket</h4>
                </td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('plugin-scripts')
{!! Html::script('/assets/plugins/chartjs/chart.min.js') !!}
{!! Html::script('/assets/plugins/jquery-sparkline/jquery.sparkline.min.js') !!}
@endpush

@push('custom-scripts')
{!! Html::script('/assets/js/dashboard.js') !!}
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
<script>
  $(document).ready(function() {
    
    $('#allTicket').DataTable();
    
  });
</script>
@endpush