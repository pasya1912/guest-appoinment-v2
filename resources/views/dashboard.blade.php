@extends('layout.master')

@push('plugin-styles')
<!-- {!! Html::style('/assets/plugins/plugin.css') !!} -->
@endpush

@section('content')

@can('GA')
<div class="row">
  <div class="col-lg-12 grid-margin">

    @if (session('selesai'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('selesai') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="card">
      <div class="card-body p-5">
        <div class="row">
          <div class="col-12">
              <h4 class="card-title mb-5">Kebutuhan Tamu Hari ini <small class="text-muted"> / 
                今日のゲストニーズ</small></h4>
              @if (!$facilities->isEmpty())
              @foreach ($facilities as $facility)
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingOne">
                          <h4 class="panel-title">
                              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{ $facility->id }}" aria-expanded="true" aria-controls="collapseOne">
                                  Ticket ID : {{ $facility->appointment_id }} 
                                  @if ($facility->date == date("Y-m-d"))
                                  <span class="badge badge-pill badge-danger ml-3">Today!</span>
                                  @endif
                                </a>
                          </h4>
                      </div>
                      <div id="collapse-{{ $facility->id }}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                          <div class="panel-body">
                            <ul class="list-group">
                              @if ($facility->snack_kering != 0 || $facility->snack_kering != null)  
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  Snack Kering
                                  <h4><span class="badge badge-lg badge-primary badge-pill"> Jumlah : {{ $facility->snack_kering }}</span></h4>
                                </li>
                              @endif
                              @if ($facility->snack_basah != 0 || $facility->snack_basah != null)  
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  Snack Basah
                                  <h4><span class="badge badge-primary badge-pill"> Jumlah : {{ $facility->snack_basah }}</span></h4>
                                </li>
                              @endif
                              @if ($facility->makan_siang != 0 || $facility->makan_siang != null)  
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  Makan Siang
                                  <h4><span class="badge badge-primary badge-pill"> Jumlah : {{ $facility->makan_siang }}</span></h4>
                                </li>
                              @endif
                              @if ($facility->permen != 0 || $facility->permen != null)  
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  Permen
                                  <h4><span class="badge badge-primary badge-pill"> Jumlah : {{ $facility->permen }}</span></h4>
                                </li>
                              @endif
                              @if ($facility->kopi != 0 || $facility->kopi != null)  
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  Kopi
                                  <h4><span class="badge badge-primary badge-pill"> Jumlah : {{ $facility->kopi }}</span></h4>
                                </li>
                              @endif
                              @if ($facility->teh != 0 || $facility->teh != null)  
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  Teh
                                  <h4><span class="badge badge-primary badge-pill"> Jumlah : {{ $facility->teh }}</span></h4>
                                </li>
                              @endif
                              @if ($facility->soft_drink != 0 || $facility->soft_drink != null)  
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  Soft Drink
                                  <h4><span class="badge badge-primary badge-pill"> Jumlah : {{ $facility->soft_drink }}</span></h4>
                                </li>
                              @endif
                              @if ($facility->air_mineral != 0 || $facility->air_mineral != null)  
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  Air Mineral
                                  <h4><span class="badge badge-primary badge-pill"> Jumlah : {{ $facility->air_mineral }}</span></h4>
                                </li>
                              @endif
                              @if ($facility->helm != 0 || $facility->helm != null)  
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  Helm
                                  <h4><span class="badge badge-primary badge-pill"> Jumlah : {{ $facility->helm }}</span></h4>
                                </li>
                              @endif
                              @if ($facility->handuk != 0 || $facility->handuk != null)  
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  Handuk
                                  <h4><span class="badge badge-primary badge-pill"> Jumlah : {{ $facility->handuk }}</span></h4>
                                </li>
                              @endif
                              @if ($facility->speaker != 0 || $facility->speaker != null)  
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  Speaker
                                  <h4><span class="badge badge-primary badge-pill"> Jumlah : {{ $facility->speaker }}</span></h4>
                                </li>
                              @endif
                              @if ($facility->speaker_wireless != 0 || $facility->speaker_wireless != null)  
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  Speaker Wireless
                                  <h4><span class="badge badge-primary badge-pill"> Jumlah : {{ $facility->speaker_wireless }}</span></h4>
                                </li>
                              @endif
                              @if ($facility->mobil != 0 || $facility->mobil != null)  
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  Parkir Mobil
                                  <h4><span class="badge badge-primary badge-pill"> Jumlah : {{ $facility->mobil }}</span></h4>
                                </li>
                              @endif
                              @if ($facility->motor != 0 || $facility->motor != null)  
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  Parkir Motor
                                  <h4><span class="badge badge-primary badge-pill"> Jumlah : {{ $facility->motor }}</span></h4>
                                </li>
                              @endif
                              @if ($facility->mini_bus != 0 || $facility->mini_bus != null)  
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  Parkir Mini Bus
                                  <h4><span class="badge badge-primary badge-pill"> Jumlah : {{ $facility->mini_bus }}</span></h4>
                                </li>
                              @endif
                              @if ($facility->bus != 0 || $facility->bus != null)  
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  Parkir Bus
                                  <h4><span class="badge badge-primary badge-pill"> Jumlah : {{ $facility->bus }}</span></h4>
                                </li>
                              @endif
                            </ul>
                            <form action="/facility-done/{{ $facility->appointment_id }}" method="post">
                              {{ csrf_field() }}
                              <button class="btn btn-outline-primary btn-lg mt-3">Selesai Disiapkan</button>
                            </form>
                          </div>
                      </div>
                  </div>
                </div>
              @endforeach
              @else
                  <h3 class="text-center">Tidak ada yang perlu disiapkan hari ini :)</h3>
              @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endcan

@can('approver')
<div class="row">
  <div class="col-lg-12 grid-margin">
    <div class="card">
      <div class="card-body p-5">
        <div class="row">
          <div class="col-10">
            <h4 class="card-title mb-5">Today's Appointment <small class="text-muted"> / 
              今日の予定</small></h4>
          </div>
        </div>
        <table class="table table-responsive-lg" id="allTicket">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Visitor Name <small class="text-muted"> / 訪問者名</small></th>
              <th class="text-center">Visit Purpose <small class="text-muted"> / 訪問目的</small></th>
              <th class="text-center">Visit Date <small class="text-muted"> / 訪問日</small></th>
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
              <td class="display-4">{{ Carbon\Carbon::parse($appointment->end_date)->toFormattedDateString() }}</td>
              <td class="display-4">{{ $appointment->pic->name }}</td>
              
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
              <p class="mb-0 text-right">Today's Appointment</p>
              <div class="fluid-container">
                <h3 class="font-weight-medium text-right mb-0">{{ $today_appointment }}</h3>
              </div>
            </div>
          </div>
          <p class="text-muted mt-3 mb-0 text-left text-md-center text-xl-left">
            <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i> {{ Carbon\Carbon::parse()->toFormattedDateString() }}<small class="text-muted"> / Janji temu hari ini</small></p>
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
                  <h4 class="card-title mb-5">Today's Appointment<small class="text-muted"> / Janji Temu Hari ini</small></h4>
                </div>
                <div class="col-2 text-right">
                  <form action="{{ route('appointment.export') }}" method="post">
                    {{ csrf_field() }}
                    @if(!$appointments->isEmpty())
                      <button type="submit" class="btn btn-info"><i class="mdi mdi-file-export pr-1"></i>Export</button>
                    @else
                      <button type="submit" class="btn btn-info" disabled><i class="mdi mdi-file-export pr-1"></i>Export</button>
                    @endif
                  </form>
                </div>
              </div>
              <table class="table table-responsive-lg" id="allTicket">
                <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Visitor Name</th>
                    <th class="text-center">Visit Purpose</th>
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
                    <td class="display-4">{{ Carbon\Carbon::parse($appointment->date)->toFormattedDateString() }}</td>
                    <td class="display-4">{{ $appointment->pic->name }}</td>
                    
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
                  
                  <!-- Modal -->
                  @foreach ($appointments as $appointment)   
                  <div class="modal fade auto-off" id="demoModal-{{ $appointment->id }}" tabindex="-1" role="dialog" aria-labelledby="demoModal-{{ $appointment->id }}" aria-hidden="true">
                    <div class="modal-dialog animated zoomInDown modal-dialog-centered" role="document">
                      <div class="modal-content">
                        
                        <div class="container-fluid">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                          <div class="row">
                            <div class="col-md-12 text-center py-5 px-sm-5 ">
                              <h2>Your Barcode is Here!</h2>
                              <p class="text-muted">show this barcode to the security guard</p>
                              <span>{!! \QrCode::size(200)->generate($appointment->id) !!}</span>
                              <h5 class="mt-3">id={{ $appointment->id }}</h5>
                              <form class="pt-5">
                                <button type="submit" class="btn btn-primary" data-dismiss="modal" aria-label="Close">close modal</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                  <!-- Modal Ends -->

                  <h4 class="card-title mb-5">Today's Appointment<small class="text-muted"> / 
                    今日の予定</small></h4>
                </div>
              </div>
              <table class="table table-responsive-lg" id="allTicket">
                <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">PIC <small class="text-muted"> / 担当者</small></th>
                    <th class="text-center">Visit Purpose <small class="text-muted"> / 訪問目的</small></th>
                    <th class="text-center">Visit Date<small class="text-muted"> / 訪問日</small></th>
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
                    <td class="display-4">{{ Carbon\Carbon::parse($appointment->date)->toFormattedDateString() }}</td>
                    <td>
                      <button data-toggle="modal" data-target="#demoModal-{{ $appointment->id }}"data-toggle="tooltip" title="QR Code" type="submit" class="btn btn-icons btn-inverse-info">
                        <i class="mdi mdi-qrcode"></i>
                      </button>
                    </td>
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