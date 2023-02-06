@extends('layout.master')

@push('plugin-styles')
<!-- {!! Html::style('/assets/plugins/plugin.css') !!} -->
@endpush

@section('content')

@can('approver')
<div class="row">
  <div class="col-lg-12 grid-margin">
    <div class="card">
      <div class="card-body p-5">
        <div class="row">
          <div class="col-10">
            <h4 class="card-title mb-5">Active Ticket <small class="text-muted"> / 
              有効なチケット</small></h4>
          </div>
        </div>
        <table class="table table-responsive" id="allTicket">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Visitor Name <small class="text-muted"> / 訪問者名</small></th>
              <th class="text-center">Visit Purpose <small class="text-muted"> / 訪問目的</small></th>
              <th class="text-center">Visit Date <small class="text-muted"> / 訪問日</small></th>
              <th class="text-center">Visit Time <small class="text-muted"> / 訪問時間</small></th>
              <th class="text-center">PIC <small class="text-muted"> / 担当者</small></th>
              <th class="text-center">Checkin Status</th>
            </tr>
          </thead>
          <tbody class="text-center">
            @if(!$appointments->isEmpty())
            @foreach ($appointments as $appointment)
            
            <tr>
              <td class="display-4">{{ $loop->iteration }}</td>
              <td class="display-4">{{ $appointment->name }}</td>
              <td class="display-4">{{ $appointment->purpose }}</td>
              <td class="display-4">{{ Carbon\Carbon::parse()->toFormattedDateString() }}</td>
              <td class="display-4">{{ $appointment->time }}</td>
              <td class="display-4">{{ $appointment->pic }}</td>
              
              @if($appointment->checkin->status === 'in')
              <td>
                <span class="badge badge-pill badge-success p-2 text-light">{{ $appointment->checkin->status }}</span>
              </td>
              @else
              <td>
                <span class="badge badge-pill badge-danger p-2 text-light">{{ $appointment->checkin->status }}</span>
              </td>
              @endif
              
            </tr>
            
            @endforeach
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endcan

@can('admin')
<div class="row">
  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body">
        <div class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
          <div class="float-left">
            <i class="mdi mdi-cube text-danger icon-lg"></i>
          </div>
          <div class="float-right">
            <p class="mb-0 text-right">Total Ticket</p>
            <div class="fluid-container">
              <h3 class="font-weight-medium text-right mb-0">{{ $total_appointment }}</h3>
            </div>
          </div>
        </div>
        <p class="text-muted mt-3 mb-0 text-left text-md-center text-xl-left">
          <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> Approved ticket <small class="text-muted"> / Jumlah tiket yang telah disetujui</small></p>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 grid-margin stretch-card">
      <div class="card card-statistics">
        <div class="card-body">
          <div class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
            <div class="float-left">
              <i class="mdi mdi-poll-box text-success icon-lg"></i>
            </div>
            <div class="float-right">
              <p class="mb-0 text-right">Active Ticket</p>
              <div class="fluid-container">
                <h3 class="font-weight-medium text-right mb-0">{{ $today_appointment }}</h3>
              </div>
            </div>
          </div>
          <p class="text-muted mt-3 mb-0 text-left text-md-center text-xl-left">
            <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i> {{ Carbon\Carbon::parse()->toFormattedDateString() }}<small class="text-muted"> / Jumlah tiket yang aktif</small></p>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 grid-margin stretch-card">
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
            <p class="text-muted mt-3 mb-0 text-left text-md-center text-xl-left pt-1">
              <i class="mdi mdi-reload mr-1" aria-hidden="true"></i> Visitor inside AIIA<small class="text-muted"> / Jumlah tamu yang ada di dalam AIIA</small></p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 grid-margin">
          <div class="card">
            <div class="card-body p-5">
              <div class="row container-fluid">
                <div class="col-10">
                  <h4 class="card-title mb-5">Active Ticket<small class="text-muted"> / Tiket yang masih aktif</small></h4>
                </div>
                <div class="col-2 text-right">
                  <form action="{{ route('appointment.export') }}" method="post">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-info"><i class="mdi mdi-file-export pr-1"></i>Export</button>
                  </form>
                </div>
              </div>
              <table class="table table-responsive table-responsive-lg" id="allTicket">
                <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Visitor Name</th>
                    <th class="text-center">Visit Purpose</th>
                    <th class="text-center">Plan Visit</th>
                    <th class="text-center">Visit Date</th>
                    <th class="text-center">PIC</th>
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
                    <td class="display-4">{{ $appointment->pic }}</td>
                    
                    @if($appointment->checkin->status === 'in')
                    <td>
                      <span class="badge badge-pill badge-success p-2 text-light">{{ $appointment->checkin->status }}</span>
                    </td>
                    @else
                    <td>
                      <span class="badge badge-pill badge-danger p-2 text-light">{{ $appointment->checkin->status }}</span>
                    </td>
                    @endif
                    
                  </tr>
                  
                  @endforeach
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      @endcan
      
      @can('visitor')
      <div class="row">
        <div class="col-lg-12 grid-margin">
          <div class="card">
            <div class="card-body p-5">
              <div class="row">
                <div class="col-10">
                  <h4 class="card-title mb-5">Active Ticket<small class="text-muted"> / 
                    有効なチケット</small></h4>
                </div>
              </div>
              <table class="table table-responsive-lg" id="allTicket">
                <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">PIC <small class="text-muted"> / 担当者</small></th>
                    <th class="text-center">Visit Purpose <small class="text-muted"> / 訪問目的</small></th>
                    <th class="text-center">Visit Plan<small class="text-muted"> / 見学プラン</small></th>
                    <th class="text-center">Visit Date <small class="text-muted"> / 訪問日</small></th>
                    <th class="text-center">Visit Time <small class="text-muted"> / 訪問時間</small></th>
                    <th class="text-center">QR <small class="text-muted"> / QRコード</small></th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  @if(!$appointments->isEmpty())
                  @foreach ($appointments as $appointment)
                  
                  <tr>
                    <td class="display-4">{{ $loop->iteration }}</td>
                    <td class="display-4">{{ $appointment->pic }}</td>
                    <td class="display-4">{{ $appointment->purpose }}</td>
                    <td class="display-4">{{ $appointment->frequency }}</td>
                    <td class="display-4">{{ Carbon\Carbon::parse()->toFormattedDateString() }}</td>
                    <td class="display-4">{{ $appointment->time }}</td>
                    
                  </tr>
                  
                  @endforeach
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      @endcan
      
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
          
          $('#allTicket').DataTable({
            "lengthChange": false
          });
          
        });
      </script>
      @endpush